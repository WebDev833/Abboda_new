<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Media;
use App\Models\Upload;

class UploadController extends Controller
{

    /**
     * Common page configs.
     */
    private $pageConfigs = [
        'title' => 'Media Library',
        'breadcrumb' => false,
    ];

    public function index()
    {
      return view('admin.pages.media.index', [
          'pageConfigs' => $this->pageConfigs,
      ]);
    }

    /**
     * All media of a collection
     */
    public function all($collection = NULL)
    {
      $medias = Media::where('model_type', '=', 'App\Models\Upload');
      if ($collection) {
          $medias = $medias->where('collection_name', $collection);
      }
      $allMedias = $medias->orderBy('id','desc')->get();
      
      return $allMedias->toJson();
    }
    
    /**
     * Collection Names
     */
    public function collectionsNames()
    {
      $medias = Media::all('collection_name')->pluck('collection_name','collection_name')->map(function ($c) {
          return ['value' => $c,
                'title' => title_case(preg_replace('/_/', ' ', $c))
            ];
        })->unique();
      unset($medias['default']);
      $medias->prepend(['value' => 'default', 'title' => 'Default'],'default');
      return $medias;
    }

    /**
     * clear cache from Upload table
     */
    public function clear(Request $request)
    {
      $input = $request->all();
      if ($input['uuid']) {
        $uploadModel = Upload::query()->where('uuid', $input['uuid'])->first();
        if(!is_null($uploadModel))
        {
          return $uploadModel->delete();
        }
        return false;      
      }
      return false;
    }

    /**
     * @param UploadRequest $request
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // echo '<pre>';
        // print_r($input);
        // die();

        $upload = Upload::create($input);
        
        $upload->addMedia($input['file'])
            ->withCustomProperties(['uuid' => $input['uuid']])
            ->toMediaCollection($input['field']);
        return true;       
    }

}
