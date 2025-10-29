<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    // Patient Routes
    Route::get('/patients/new', function () {
        return Inertia::render('patients/NewPatient');
    })->name('patients.create');

    Route::get('/patients/{patient}/edit', function ($patient) {
        return Inertia::render('patients/EditPatient', [
            'patient' => $patient
        ]);
    })->name('patients.edit');

    Route::get('/patients/{patient}/records', function ($patient) {
        return Inertia::render('records/RecordList', [
            'patient' => $patient
        ]);
    })->name('patients.records');

    Route::get('/patients/{patient}/records/new', function ($patient) {
        return Inertia::render('records/NewRecord', [
            'patient' => $patient
        ]);
    })->name('records.create');

    Route::get('/patients/{patient}/records/{record}/edit', function ($patient, $record) {
        return Inertia::render('records/EditRecord', [
            'patient' => $patient,
            'record' => $record
        ]);
    })->name('records.edit');
});