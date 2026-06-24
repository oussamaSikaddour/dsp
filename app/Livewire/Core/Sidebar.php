<?php

namespace App\Livewire\Core;

use App\Models\Menu;
use App\Models\Service;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Sidebar extends Component
{




    public string $superAdminDropdownLink;
     public array $superAdminDropdownItems=[];
    // public string $adminDropdownLink;
    //  public array $adminDropdownItems=[];







    public function  mount() {


 $this->superAdminDropdownLink=__('sidebar.dropdowns.super_admin');


    $this->superAdminDropdownItems= [
            [
                'route' =>"wilayates",
                'label' => __('pages.wilayates.name'),
                'icon' => 'wilaya',

            ],
            [
                'route' =>"occupation_fields",
                'label' => __('pages.occupation_fields.name'),
                'icon' => 'suitcase',
            ],


        ];

// $this->adminDropdownLink=__('sidebar.dropdowns.admin');

// $this->adminDropdownItems=[
//     [
//         'route'=>"measurement_units_route",
//         'label'=>__('pages.manage_measurement_units.name'),
//          'icon'=>'list'
// ],
//     [
//         'route'=>"categories_route",
//         'label'=>__('pages.manage_categories.name'),
//          'icon'=>'list'
// ],

// ];

    }
    public function render()
    {
        return view('livewire.core.sidebar');
    }
}
