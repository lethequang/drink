<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation

class MenuItemCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        $this->crud->setModel("App\Models\MenuItem");
        $this->crud->setRoute(config('backpack.base.route_prefix').'/menu-item');
        $this->crud->setEntityNameStrings('menu item', 'menu items');

        $this->crud->allowAccess('reorder');
        $this->crud->enableReorder('name', 2);

        $this->crud->addColumn([
                                'name' => 'name',
                                'label' => 'Tên menu',
                            ]);
        $this->crud->addColumn([ // select_from_array
            'name' => 'position',
            'label' => "Vị trí menu",
            'type' => 'select_from_array',
            'options' => ['main' => 'Menu Chính', 'footer' => 'Menu Footer'],
        ]);
        $this->crud->addColumn([
                                'label' => 'Menu Cha',
                                'type' => 'select',
                                'name' => 'parent_id',
                                'entity' => 'parent',
                                'attribute' => 'name',
                                'model' => "App\Models\MenuItem",
                            ]);

        $this->crud->addField([
                                'name' => 'name',
                                'label' => 'Tên menu',
                            ]);
        $this->crud->addField([   // select_from_array
            'name' => 'position',
            'label' => "Vị trị Menu",
            'type' => 'select2_from_array',
            'options' => ['' => 'Chọn vị trí menu', 'main' => 'Menu Chính', 'footer' => 'Menu Footer'],
            'allows_null' => false,
            'data-placeholder' => 'Chọn vị trí menu'
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);
        $this->crud->addField([
                                'label' => 'Menu Cha',
                                'type' => 'select',
                                'name' => 'parent_id',
                                'entity' => 'parent',
                                'attribute' => 'name',
                                'model' => "App\Models\MenuItem",
                            ]);
        $this->crud->addField([
                                'name' => 'type',
                                'label' => 'Loại menu',
                                'type' => 'page_or_link',
                                'page_model' => '\Backpack\PageManager\app\Models\Page',
                            ]);
    }

    public function store(Request $request)
    {
        return parent::storeCrud($request);
    }

    public function update(Request $request)
    {
        return parent::updateCrud($request);
    }
}
