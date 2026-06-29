<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\ContactController;

Route::get('/', [ShowController::class, 'index'])->name('home');
Route::get('/over-ons', [ShowController::class, 'about'])->name('about');
Route::get('/contact', [ShowController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/shows/{show}', [ShowController::class, 'show'])->name('shows.show');
Route::get('/shows/{show}/book', [ShowController::class, 'book'])->name('shows.book');
Route::post('/shows/{show}/book', [ShowController::class, 'storeBooking'])->name('shows.book.store');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Admin only: rol-check zit in controller
    Route::get('/admin/medewerkers', [EmployeeController::class, 'index'])->name('admin.medewerkers');
    Route::post('/admin/medewerkers', [EmployeeController::class, 'store'])->name('admin.medewerkers.store');
    Route::put('/admin/medewerkers/{user}', [EmployeeController::class, 'update'])->name('admin.medewerkers.update');
    Route::delete('/admin/medewerkers/{user}', [EmployeeController::class, 'destroy'])->name('admin.medewerkers.destroy');

    // Medewerker / Admin: ticketbeheer
    Route::get('/medewerker/tickets', [ReservationController::class, 'index'])->name('tickets.index');
    Route::post('/medewerker/tickets', [ReservationController::class, 'storeManual'])->name('tickets.store.manual');
    Route::get('/medewerker/scan', [ReservationController::class, 'scan'])->name('tickets.scan');
    Route::post('/medewerker/scan', [ReservationController::class, 'scan']);
    Route::put('/medewerker/tickets/{reservation}', [ReservationController::class, 'update'])->name('tickets.update');
    Route::delete('/medewerker/tickets/{reservation}', [ReservationController::class, 'destroy'])->name('tickets.destroy');

    // Medewerker / Admin: voorstellingenbeheer
    Route::get('/medewerker/shows', [ShowController::class, 'employeeIndex'])->name('employee.shows.index');
    Route::post('/medewerker/shows', [ShowController::class, 'employeeStore'])->name('employee.shows.store');
    Route::put('/medewerker/shows/{show}', [ShowController::class, 'employeeUpdate'])->name('employee.shows.update');
    Route::delete('/medewerker/shows/{show}', [ShowController::class, 'employeeDestroy'])->name('employee.shows.destroy');

    // Medewerker / Admin: klachten & contactberichten
    Route::get('/medewerker/contacts', [ContactController::class, 'index'])->name('employee.contacts.index');
    Route::put('/medewerker/contacts/{id}', [ContactController::class, 'update'])->name('employee.contacts.update');
    Route::patch('/medewerker/contacts/{id}/gereed', [ContactController::class, 'markGereed'])->name('employee.contacts.done');
    Route::delete('/medewerker/contacts/{id}', [ContactController::class, 'destroy'])->name('employee.contacts.destroy');

    // Bezoeker: reserveren & eigen tickets
    Route::get('/reserveer', [ReservationController::class, 'create'])->name('reserveer');
    Route::post('/reserveer', [ReservationController::class, 'store']);
    Route::get('/mijn-tickets', [ReservationController::class, 'mijnTickets'])->name('mijn.tickets');
});

