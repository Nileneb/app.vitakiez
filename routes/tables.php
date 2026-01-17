<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('tables/wgs', fn () => view('pages.tables.wg'))->name('tables.wgs');
    Route::get('tables/cases', fn () => view('pages.tables.cases'))->name('tables.cases');
    Route::get('tables/issues', fn () => view('pages.tables.issues'))->name('tables.issues');
    Route::get('tables/authorities', fn () => view('pages.tables.authorities'))->name('tables.authorities');
    Route::get('tables/source-evidence', fn () => view('pages.tables.source_evidence'))->name('tables.source-evidence');
});
