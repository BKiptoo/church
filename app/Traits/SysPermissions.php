<?php

namespace App\Traits;

trait SysPermissions
{
    public string $viewDashBoardAnalytics = 'View Dashboard Analytics';
    public string $usersManagement = 'Users Management';
    public string $impactTypesManagement = 'Impact Type Management';
    public string $impactsManagement = 'Impacts Management';
    public string $adsManagement = 'Ads Management';
    public string $contactsManagement = 'Contacts Management';
    public string $careersManagement = 'Careers Management';
    public string $subscribersManagement = 'Subscribers Management';
    public string $coveragesManagement = 'Coverages Management';
    public string $eventsManagement = 'Events Management';
    public string $faqsManagement = 'Faqs Management';
    public string $officeManagement = 'Office Management';
    public string $categoryManagement = 'Category Management';
    public string $subCategoryManagement = 'Sub Category Management';
    public string $productsManagement = 'Products Management';
    public string $ordersManagement = 'Orders Management';
    public string $blogsManagement = 'Blogs Management';
    public string $slideManagement = 'Slide Management';
    public string $teamManagement = 'Team Management';
    public string $tendersManagement = 'Tenders Management';
    public string $mediaFileManagement = 'Media/File Management';


    public function permissions(): array
    {
        return [
            $this->viewDashBoardAnalytics,
            $this->impactsManagement,
            $this->impactTypesManagement,
            $this->careersManagement,
            $this->usersManagement,
            $this->adsManagement,
            $this->subscribersManagement,
            $this->contactsManagement,
            $this->coveragesManagement,
            $this->eventsManagement,
            $this->faqsManagement,
            $this->officeManagement,
            $this->categoryManagement,
            $this->subCategoryManagement,
            $this->productsManagement,
            $this->ordersManagement,
            $this->blogsManagement,
            $this->slideManagement,
            $this->teamManagement,
            $this->tendersManagement,
            $this->mediaFileManagement
        ];
    }
}
