<?php

namespace App\Observers;

use App\Models\CaseModel;
use App\Models\Issue;
use App\Models\Authority;

class CaseObserver
{
    public function created(CaseModel $case): void
    {
        $this->syncIssues($case);
        $this->syncAuthorities($case);
    }

    public function updated(CaseModel $case): void
    {
        $this->syncIssues($case);
        $this->syncAuthorities($case);
    }

    /**
     * Parse issue_categories (semicolon-separated or single code) and sync to case_issue
     */
    private function syncIssues(CaseModel $case): void
    {
        if (!$case->issue_categories) {
            return;
        }

        // Split by semicolon
        $codes = array_filter(array_map('trim', explode(';', $case->issue_categories)));
        $issueIds = [];

        foreach ($codes as $code) {
            $issue = Issue::where('code', $code)->first();
            if ($issue) {
                $issueIds[] = $issue->id;
            }
        }

        // Sync without detaching old (allows API updates)
        if (!empty($issueIds)) {
            $case->issues()->syncWithoutDetaching($issueIds);
        }
    }

    /**
     * Parse authority_targets (semicolon-separated or single authority) and sync to case_authority
     */
    private function syncAuthorities(CaseModel $case): void
    {
        if (!$case->authority_targets) {
            return;
        }

        // Split by semicolon
        $targets = array_filter(array_map('trim', explode(';', $case->authority_targets)));
        $authorityIds = [];

        foreach ($targets as $target) {
            $authority = Authority::where('name', $target)
                ->orWhere('authority_type', $target)
                ->first();
            if ($authority) {
                $authorityIds[] = $authority->id;
            }
        }

        // Sync without detaching old
        if (!empty($authorityIds)) {
            $case->authorities()->syncWithoutDetaching($authorityIds);
        }
    }
}
