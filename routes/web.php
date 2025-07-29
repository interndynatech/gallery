<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ApplicantController,
    CareerController,
    ClientController,
    ClientGalleryController,
    CompanyController,
    compProjectsController,
    ContactController,
    DocumentsController,
    NewsController,
    OrgchartController,
    PagesController,
    ProductsController
};

/*
|--------------------------------------------------------------------------
| Public Routes (Untuk pengguna biasa)
|--------------------------------------------------------------------------
*/

// Pages
Route::get('/', [PagesController::class, 'homepage'])->name('home-page');
Route::get('about-us', [PagesController::class, 'aboutUs'])->name('about-us');
Route::get('our-team', [PagesController::class, 'ourTeam'])->name('our-team');
Route::get('careers', [PagesController::class, 'careers'])->name('careers');
Route::get('careersApply{id}', [PagesController::class, 'careersApply'])->name('careersApply');
Route::post('storeApplicants', [PagesController::class, 'storeApplicants'])->name('storeApplicants');
Route::get('products', [PagesController::class, 'products'])->name('products');
Route::get('productsDetails{id}', [PagesController::class, 'productsDetails'])->name('productsDetails');
Route::get('projects', [PagesController::class, 'projects'])->name('projects');
Route::get('project-group/{title}', [PagesController::class, 'projectGroupDetails'])->name('projectGroupDetails');
Route::get('newsAndUpdate', [PagesController::class, 'newsAndUpdate'])->name('newsAndUpdate');
Route::get('newsAndUpdateDetails{id}', [PagesController::class, 'newsAndUpdateDetails'])->name('newsAndUpdateDetails');
Route::get('contactUs', [PagesController::class, 'contactUs'])->name('contactUs');
Route::post('storeContact', [PagesController::class, 'storeContact'])->name('storeContact');
Route::get('documents', [PagesController::class, 'documents'])->name('documents');

// Galeri Klien (untuk pengguna awam) 2025
Route::get('/client-gallery/{type}', [ClientGalleryController::class, 'selectClient'])->name('clientGallery');
Route::get('/client-gallery/{type}/{client_id}', [ClientGalleryController::class, 'clientGallery'])->name('clientGallery.client');

/*
|--------------------------------------------------------------------------
| Dashboard & Admin Panel (Hanya selepas login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    })->name('admin.pages.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Routes (prefix: pages)
    |--------------------------------------------------------------------------
    */
    Route::prefix('pages')->as('admin.pages.')->group(function () {
        //Gallery Client 2025
        Route::get('client-gallery', [ClientGalleryController::class, 'index'])->name('clientGallery');
        Route::get('/client-gallery/create', [ClientGalleryController::class, 'create'])->name('clients.createClientGallery');
        Route::post('/store-client-gallery', [ClientGalleryController::class, 'store'])->name('clients.storeClientGallery');
        Route::delete('/deleteClientGallery/{id}', [ClientGalleryController::class, 'destroy'])->name('clients.deleteClientGallery');
        Route::get('/client-gallery/all', [ClientGalleryController::class, 'showAll'])->name('client.gallery.showAll');
        Route::get('/admin/client-gallery/edit/{id}', [ClientGalleryController::class, 'edit'])->name('admin.pages.clients.editClientGallery');
        Route::put('client-gallery/{id}', [ClientGalleryController::class, 'update'])->name('client-gallery.update');

        // Company Achievements
        Route::get('/achievements', [CompanyController::class, 'achievements'])->name('achievements');
        Route::post('/store', [CompanyController::class, 'store'])->name('store');
        Route::post('/update/{id}', [CompanyController::class, 'update'])->name('update');
        Route::get('/show/{id}', [CompanyController::class, 'show'])->name('show');
        Route::delete('/delete/{categoriesId}', [CompanyController::class, 'delete'])->name('delete');

        // Company Projects
        Route::get('/compProjects', [compProjectsController::class, 'compProjects'])->name('compProjects');
        Route::post('/storeProjects', [compProjectsController::class, 'storeProjects'])->name('storeProjects');
        Route::get('/showProjects/{id}', [compProjectsController::class, 'showProjects'])->name('showProjects');
        Route::post('/updateProjects/{id}', [compProjectsController::class, 'updateProjects'])->name('updateProjects');
        Route::delete('/deleteProjects/{categoriesId}', [compProjectsController::class, 'delete'])->name('delete');

        // Clients
        Route::get('/clients', [ClientController::class, 'clients'])->name('clients');
        Route::post('/storeClients', [ClientController::class, 'storeClients'])->name('storeClients');
        Route::get('/showClients/{id}', [ClientController::class, 'showClients'])->name('showClients');
        Route::post('/updateClients/{id}', [ClientController::class, 'updateClients'])->name('updateClients');
        Route::delete('/deleteClients/{clientId}', [ClientController::class, 'delete'])->name('delete');

        // Careers
        Route::get('/career', [CareerController::class, 'career'])->name('career');
        Route::post('/storeCareer', [CareerController::class, 'storeCareer'])->name('storeCareer');
        Route::get('/showCareer/{id}', [CareerController::class, 'showCareer'])->name('showCareer');
        Route::post('/updateCareer/{id}', [CareerController::class, 'updateCareer'])->name('updateCareer');
        Route::delete('/deleteCareer/{careerId}', [CareerController::class, 'delete'])->name('delete');

        // Applicants
        Route::get('/applicants', [ApplicantController::class, 'applicants'])->name('applicants');
        Route::get('/showApplicants/{id}', [ApplicantController::class, 'showApplicants'])->name('showApplicants');
        Route::post('/updateApplicants/{id}', [ApplicantController::class, 'updateApplicants'])->name('updateApplicants');
        Route::delete('/deleteApplicants/{applicantId}', [ApplicantController::class, 'deleteApplicants'])->name('deleteApplicants');

        // Contact
        Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
        Route::get('/showContact/{id}', [ContactController::class, 'showContact'])->name('showContact');
        Route::post('/updateContact/{id}', [ContactController::class, 'updateContact'])->name('updateContact');
        Route::delete('/deleteContact/{contactId}', [ContactController::class, 'deleteContact'])->name('deleteContact');

        // News
        Route::get('/news', [NewsController::class, 'news'])->name('news');
        Route::post('/storeNews', [NewsController::class, 'storeNews'])->name('storeNews');
        Route::get('/showNews/{id}', [NewsController::class, 'showNews'])->name('showNews');
        Route::post('/updateNews/{id}', [NewsController::class, 'updateNews'])->name('updateNews');
        Route::delete('/deleteNews/{newsId}', [NewsController::class, 'deleteNews'])->name('deleteNews');

        // Products & Categories
        Route::get('/products', [ProductsController::class, 'products'])->name('products');
        Route::post('/storeProducts', [ProductsController::class, 'storeProducts'])->name('storeProducts');
        Route::get('/showProducts/{id}', [ProductsController::class, 'showProducts'])->name('showProducts');
        Route::post('/updateProducts/{productId}', [ProductsController::class, 'updateProducts'])->name('updateProducts');
        Route::delete('/deleteProducts/{productId}', [ProductsController::class, 'deleteProducts'])->name('deleteProducts');

        Route::get('/categoriesList', [ProductsController::class, 'categoriesList'])->name('categoriesList');
        Route::post('/storeCategories', [ProductsController::class, 'storeCategories'])->name('storeCategories');
        Route::delete('/deleteCategories/{categoryId}', [ProductsController::class, 'deleteCategories'])->name('deleteCategories');

        // Org Chart
        Route::get('/orgchart', [OrgchartController::class, 'orgchart'])->name('orgchart');
        Route::get('/showOrgchart/{orgChartId}', [OrgchartController::class, 'showOrgchart'])->name('showOrgchart');
        Route::post('/updateOrgChart/{id}', [OrgchartController::class, 'updateOrgChart'])->name('updateOrgchart');

        // Documents
        Route::get('/documents', [DocumentsController::class, 'documents'])->name('documents');
        Route::get('/showDocuments/{docId}', [DocumentsController::class, 'showDocuments'])->name('showDocuments');
        Route::post('/storeDocuments', [DocumentsController::class, 'storeDocuments'])->name('storeDocuments');
        Route::post('/updateDocuments/{id}', [DocumentsController::class, 'updateDocuments'])->name('updateDocuments');
        Route::delete('/deleteDocuments/{docId}', [DocumentsController::class, 'deleteDocuments'])->name('deleteDocuments');
    });
});

// Auth routes
require __DIR__ . '/auth.php';