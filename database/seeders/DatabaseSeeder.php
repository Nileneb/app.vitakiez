<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wg;
use App\Models\Issue;
use App\Models\Authority;
use App\Models\CaseModel;
use App\Models\SourceEvidence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user without using factory (faker not available in production)
        $password = 'TestPass123!';
        $user = User::create([
            'name' => 'nileneb',
            'email' => 'bene.linn@yahoo.de',
            'email_verified_at' => now(),
            'password' => bcrypt($password),
            'remember_token' => Str::random(10),
        ]);

        // Save password to .env for testing
        $this->savePasswordToEnv($password);

        // Create some WGs
        $wg1 = Wg::create([
            'owner_user_id' => $user->id,
            'name' => 'Pflege-WG Linn',
            'state' => 'NRW',
            'district' => 'Köln',
            'municipality' => 'Köln',
            'address_text' => 'Kölnstraße 42, 50733 Köln',
            'governance' => 'SELF_ORGANIZED',
            'residents_total' => 8,
            'residents_with_pg' => 6,
            'target_group' => 'Senioren mit Pflegebedarf',
            'has_24h_presence' => true,
            'has_presence_staff' => true,
            'care_provider_mode' => 'MIXED',
            'lease_individual' => true,
            'care_individual' => false,
            'bundle_housing_care' => true,
            'sgb_xi_used' => true,
            'sgb_xii_involved' => true,
            'sgb_v_hkp' => false,
        ]);

        $wg2 = Wg::create([
            'owner_user_id' => $user->id,
            'name' => 'Gemeinschaftswohnen Bremen',
            'state' => 'Bremen',
            'district' => null,
            'municipality' => 'Bremen',
            'address_text' => 'Bremenstraße 123, 28215 Bremen',
            'governance' => 'PROVIDER_ORGANIZED',
            'residents_total' => 12,
            'residents_with_pg' => 8,
            'target_group' => 'Personen mit Behinderungen',
            'has_24h_presence' => false,
            'has_presence_staff' => true,
            'care_provider_mode' => 'SINGLE_PROVIDER',
        ]);

        // Set first WG as active
        $user->active_wg_id = $wg1->id;
        $user->save();

        // Create some Issues (Rechtskategorien)
        $issue1 = Issue::create([
            'code' => 'WG_ZUSCHLAG_38A',
            'name' => 'WG-Zuschlag nach § 38a SGB XI',
            'description' => 'Zusätzliche Leistungen für Pflege-WGs',
            'rule_hints' => 'Maximal 214€/Monat für bis zu 4 Personen',
        ]);

        $issue2 = Issue::create([
            'code' => 'WOHNUNG_ANPASSUNG',
            'name' => 'Wohnungsanpassungsmaßnahmen',
            'description' => 'Kostenübernahme für altersgerechte Umbauten',
            'rule_hints' => 'Max. 4.000€ pro Maßnahme, bis zu 20.000€ gesamt',
        ]);

        $issue3 = Issue::create([
            'code' => 'HEIMAUFSICHT_ANFORDERUNG',
            'name' => 'Heimaufsichtsrechtliche Anforderungen',
            'description' => 'Compliance mit Wohn- und Teilhabegesetze',
            'rule_hints' => 'Variiert nach Bundesland',
        ]);

        // Create some Authorities (Behörden)
        $auth1 = Authority::create([
            'authority_type' => 'CARE_FUND',
            'name' => 'Krankenkasse AOK Rheinland',
            'jurisdiction_state' => 'NRW',
            'jurisdiction_district' => 'Köln',
            'jurisdiction_municipality' => 'Köln',
            'website_url' => 'https://www.aok.de/pk/nrw',
            'email' => 'kontakt@aok-nrw.de',
            'phone' => '+49 221 123456',
        ]);

        $auth2 = Authority::create([
            'authority_type' => 'HEIMAUFSICHT_WTG',
            'name' => 'Heimaufsicht NRW',
            'jurisdiction_state' => 'NRW',
            'jurisdiction_district' => 'Köln',
            'website_url' => 'https://www.mags.nrw/wtg',
            'phone' => '+49 211 987654',
        ]);

        // Create a Case
        $case = CaseModel::create([
            'wg_id' => $wg1->id,
            'created_by_user_id' => $user->id,
            'title' => 'WG-Zuschlag § 38a beantragen',
            'status' => 'IN_PROGRESS',
            'problem_description' => 'Wir benötigen Informationen zur korrekten Beantragung des WG-Zuschlags',
            'priority' => 'HIGH',
            'required_docs' => 'Wohnvertrag, Pflegestufenbescheid, Nachweise der Vollständigkeit',
            'next_actions' => 'Unterlagen zusammenstellen, Antrag bei AOK einreichen',
            'deadlines' => '2026-03-01',
        ]);

        // Attach issues to case
        $case->issues()->sync([$issue1->id, $issue3->id]);

        // Attach authorities to case
        $case->authorities()->sync([$auth1->id, $auth2->id]);

        // Add source evidence
        SourceEvidence::create([
            'case_id' => $case->id,
            'issue_id' => $issue1->id,
            'url' => 'https://www.gesetze-im-internet.de/sgb_11/__38a.html',
            'domain' => 'gesetze-im-internet.de',
            'title' => '§ 38a SGB XI - Wohngruppenzuschlag',
            'source_type' => 'LAW',
            'jurisdiction_scope' => 'FEDERAL',
            'evidence_excerpt' => 'Zugelassene Pflegeeinrichtungen, die Pflege in teilstationärer Form...',
            'authority_score' => 10,
            'relevance_score' => 10,
            'jurisdiction_score' => 10,
            'total_score' => 30,
            'selected' => true,
            'text_full' => 'Volltext des Gesetzes...',
        ]);

        SourceEvidence::create([
            'case_id' => $case->id,
            'issue_id' => $issue1->id,
            'url' => 'https://www.aok.de/pk/nrw/inhalt/wohngruppe-zuschlag',
            'domain' => 'aok.de',
            'title' => 'AOK: Informationen zum Wohngruppen-Zuschlag',
            'source_type' => 'AUTHORITY',
            'jurisdiction_scope' => 'STATE',
            'evidence_excerpt' => 'Der Wohngruppen-Zuschlag beträgt monatlich bis zu 214 Euro...',
            'authority_score' => 9,
            'relevance_score' => 10,
            'jurisdiction_score' => 9,
            'total_score' => 28,
            'selected' => true,
        ]);
    }

    /**
     * Save the test user password to .env file
     */
    protected function savePasswordToEnv(string $password): void
    {
        $envFile = base_path('.env');

        if (!file_exists($envFile)) {
            return;
        }

        $envContent = file_get_contents($envFile);

        // Remove existing TEST_USER_PASSWORD if present
        $envContent = preg_replace('/TEST_USER_PASSWORD=.*\n/', '', $envContent);

        // Add new TEST_USER_PASSWORD
        $envContent .= "\nTEST_USER_PASSWORD={$password}\n";

        file_put_contents($envFile, $envContent);
    }
}
