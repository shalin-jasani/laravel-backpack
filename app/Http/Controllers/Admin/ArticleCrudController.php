<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ArticleRequest as StoreRequest;
use App\Http\Requests\ArticleRequest as UpdateRequest;

/**
 * Class ArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ArticleCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Article');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/article');
        $this->crud->setEntityNameStrings('article', 'articles');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();

        $this->crud->addColumn([
            'name' => 'en_title',
            'label' => "English Title",
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'es_title',
            'label' => "Spanish Title",
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'published_date',
            'label' => "Date",
            'type' => "date",
            'format' => 'j F Y',
        ]);

        $this->crud->addColumn([
            'name' => 'category_id',
            'label' => "Category",
            'type' => "model_function",
            'function_name' => 'getCategoryName',
        ]);

        $this->crud->addColumn([
            'name' => 'is_published',
            'label' => "Status",
            'type' => "boolean",
            'options' => [0 => 'Not Published', 1 => 'Published']
        ]);

        $this->crud->addColumn([
            'name' => 'allow_comments',
            'label' => "Allow Comments",
            'type' => "boolean",
            'options' => [0 => 'Not Allowed', 1 => 'Allowed']
        ]);

        $this->crud->addColumn([
            'name' => 'domain_id',
            'label' => "Domain",
            'type' => "model_function",
            'function_name' => 'getDomainName',
        ]);

        $this->crud->allowAccess('show');


        $this->crud->addFilter([
            'name' => 'category_id',
            'type' => 'dropdown',
            'label'=> 'Category'
        ], function() {
            return \App\Models\Category::all()->pluck('en_category_name', 'id')->toArray();
        }, function($value) {
            $this->crud->addClause('where', 'category_id', $value);
        });

        $this->crud->addField([
            'name' => 'en_title',
            'label' => "Title (English)",
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'es_title',
            'label' => "Title (Spanish)",
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'en_body',
            'label' => 'Body (HTML) (English)',
            'type' => 'summernote',
        ]);

        $this->crud->addField([
            'name' => 'es_body',
            'label' => 'Body (HTML) (Spanish)',
            'type' => 'summernote',
        ]);

        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label' => "Tags",
            'type' => 'select2_multiple',
            'name' => 'tags', // the method that defines the relationship in your Model
            'entity' => 'tags', // the method that defines the relationship in your Model
            'attribute' => 'en_name', // foreign key attribute that is shown to user
            'model' => "App\Models\Tag", // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            // 'select_all' => true, // show Select All and Clear buttons?

            // optional
            'options'   => (function ($query) {
                return $query->latest()->get();
            }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);

        $this->crud->addField([   // Checkbox
            'name' => 'is_published',
            'label' => 'Published',
            'type' => 'checkbox'
        ]);

        $this->crud->addField([   // date_picker
            'name' => 'published_date',
            'type' => 'date_picker',
            'label' => 'Published Date',
            // optional:
            'date_picker_options' => [
                'todayBtn' => true,
                'format' => 'dd-mm-yyyy',
                'language' => 'en'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name' => 'allow_comments',
            'label' => 'Comments',
            'type' => 'checkbox'
        ]);

        $this->crud->addField([  // Select2
                'label' => "Category",
                'type' => 'select2',
                'name' => 'category_id', // the db column for the foreign key
                'entity' => 'category', // the method that defines the relationship in your Model
                'attribute' => 'en_category_name', // foreign key attribute that is shown to user
                'model' => "App\Models\Category", // foreign key model

                // optional
                'options'   => (function ($query) {
                    return $query->latest()->get();
                }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ]
        );

        $this->crud->addField([  // Select2
                'label' => "Domain",
                'type' => 'select2',
                'name' => 'domain_id', // the db column for the foreign key
                'entity' => 'domain', // the method that defines the relationship in your Model
                'attribute' => 'domain_name', // foreign key attribute that is shown to user
                'model' => "App\Models\Domain", // foreign key model
            ]
        );



        // add asterisk for fields that are required in ArticleRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
