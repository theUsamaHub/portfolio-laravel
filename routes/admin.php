<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminSiteSettingsController;
use App\Http\Controllers\Admin\AdminContactMessageController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminHeroController;
use App\Http\Controllers\Admin\AdminAboutController;
use App\Http\Controllers\Admin\AdminSkillController;
use App\Http\Controllers\Admin\AdminContentController;
use App\Http\Controllers\Admin\ImageUploadController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Image Upload
    Route::post('/upload/image', [ImageUploadController::class, 'store'])->name('upload.image');

    // Content Management
    Route::get('/hero', [AdminHeroController::class, 'edit'])->name('hero.edit');
    Route::post('/hero', [AdminHeroController::class, 'update'])->name('hero.update');

    Route::get('/about', [AdminAboutController::class, 'edit'])->name('about.edit');
    Route::post('/about', [AdminAboutController::class, 'update'])->name('about.update');

    Route::get('/skills', [AdminSkillController::class, 'index'])->name('skills.index');
    Route::post('/skills/category', [AdminSkillController::class, 'storeCategory'])->name('skills.category.store');
    Route::put('/skills/category/{category}', [AdminSkillController::class, 'updateCategory'])->name('skills.category.update');
    Route::delete('/skills/category/{category}', [AdminSkillController::class, 'destroyCategory'])->name('skills.category.destroy');
    Route::post('/skills', [AdminSkillController::class, 'storeSkill'])->name('skills.store');
    Route::put('/skills/{skill}', [AdminSkillController::class, 'updateSkill'])->name('skills.update');
    Route::delete('/skills/{skill}', [AdminSkillController::class, 'destroySkill'])->name('skills.destroy');

    Route::get('/testimonials', [AdminContentController::class, 'testimonials'])->name('testimonials.index');
    Route::post('/testimonials', [AdminContentController::class, 'storeTestimonial'])->name('testimonials.store');
    Route::delete('/testimonials/{item}', [AdminContentController::class, 'destroyTestimonial'])->name('testimonials.destroy');

    Route::get('/experiences', [AdminContentController::class, 'experiences'])->name('experiences.index');
    Route::post('/experiences', [AdminContentController::class, 'storeExperience'])->name('experiences.store');
    Route::delete('/experiences/{item}', [AdminContentController::class, 'destroyExperience'])->name('experiences.destroy');

    Route::get('/educations', [AdminContentController::class, 'educations'])->name('educations.index');
    Route::post('/educations', [AdminContentController::class, 'storeEducation'])->name('educations.store');
    Route::delete('/educations/{item}', [AdminContentController::class, 'destroyEducation'])->name('educations.destroy');

    Route::get('/services', [AdminContentController::class, 'services'])->name('services.index');
    Route::post('/services', [AdminContentController::class, 'storeService'])->name('services.store');
    Route::delete('/services/{item}', [AdminContentController::class, 'destroyService'])->name('services.destroy');

    Route::get('/tags', [AdminContentController::class, 'tags'])->name('tags.index');
    Route::post('/tags', [AdminContentController::class, 'storeTag'])->name('tags.store');
    Route::put('/tags/{item}', [AdminContentController::class, 'updateTag'])->name('tags.update');
    Route::delete('/tags/{item}', [AdminContentController::class, 'destroyTag'])->name('tags.destroy');

    Route::get('/certificates', [AdminContentController::class, 'certificates'])->name('certificates.index');
    Route::post('/certificates', [AdminContentController::class, 'storeCertificate'])->name('certificates.store');
    Route::delete('/certificates/{item}', [AdminContentController::class, 'destroyCertificate'])->name('certificates.destroy');

    Route::get('/awards', [AdminContentController::class, 'awards'])->name('awards.index');
    Route::post('/awards', [AdminContentController::class, 'storeAward'])->name('awards.store');
    Route::delete('/awards/{item}', [AdminContentController::class, 'destroyAward'])->name('awards.destroy');

    Route::get('/statistics', [AdminContentController::class, 'statistics'])->name('statistics.index');
    Route::post('/statistics', [AdminContentController::class, 'storeStatistic'])->name('statistics.store');
    Route::delete('/statistics/{item}', [AdminContentController::class, 'destroyStatistic'])->name('statistics.destroy');

    Route::get('/social-links', [AdminContentController::class, 'socialLinks'])->name('social-links.index');
    Route::post('/social-links', [AdminContentController::class, 'storeSocialLink'])->name('social-links.store');
    Route::delete('/social-links/{item}', [AdminContentController::class, 'destroySocialLink'])->name('social-links.destroy');

    Route::get('/navigation', [AdminContentController::class, 'navigation'])->name('navigation.index');
    Route::post('/navigation', [AdminContentController::class, 'storeNavigation'])->name('navigation.store');
    Route::delete('/navigation/{item}', [AdminContentController::class, 'destroyNavigation'])->name('navigation.destroy');

    Route::get('/clients', [AdminContentController::class, 'clients'])->name('clients.index');
    Route::post('/clients', [AdminContentController::class, 'storeClient'])->name('clients.store');
    Route::delete('/clients/{item}', [AdminContentController::class, 'destroyClient'])->name('clients.destroy');

    Route::get('/contact-settings', [AdminContentController::class, 'contactSettings'])->name('contact-settings.edit');
    Route::post('/contact-settings', [AdminContentController::class, 'updateContactSettings'])->name('contact-settings.update');

    Route::get('/seo', [AdminContentController::class, 'seo'])->name('seo.index');
    Route::post('/seo', [AdminContentController::class, 'updateSeo'])->name('seo.update');

    // Site Settings
    Route::get('/settings', [AdminSiteSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSiteSettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/{group}', [AdminSiteSettingsController::class, 'group'])->name('settings.group');
    Route::post('/settings/{group}', [AdminSiteSettingsController::class, 'updateGroup'])->name('settings.group.update');
    Route::post('/settings/upload', [AdminSiteSettingsController::class, 'upload'])->name('settings.upload');

    Route::get('/auth-routes', [AdminSiteSettingsController::class, 'authRoutes'])->name('auth-routes');
    Route::post('/auth-routes', [AdminSiteSettingsController::class, 'updateAuthRoutes'])->name('auth-routes.update');

    // Projects
    Route::resource('projects', AdminProjectController::class);

    // Posts/Blog
    Route::resource('posts', AdminPostController::class);

    // Contact Messages
    Route::get('/messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [AdminContactMessageController::class, 'show'])->name('messages.show');
    Route::put('/messages/{message}', [AdminContactMessageController::class, 'update'])->name('messages.update');
    Route::delete('/messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');
    Route::post('/messages/{message}/mark-unread', [AdminContactMessageController::class, 'markUnread'])->name('messages.mark-unread');
});
