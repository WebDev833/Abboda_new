<?php

use Illuminate\Database\Seeder;
use App\Helpers\Front;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        $app_settings = array(
          array(
            'key' => 'is_human_date_format',
            'value' => '1',
          ),
          array(
            'key' => 'date_format',
            'value' => 'l jS F Y (H:i:s)',
          ),
            array(
                'key' => 'front_app_name',
                'value' => 'ABBODA Application'),
            array(
                'key' => 'front_email',
                'value' => 'admin@abboda.com'),
            array(
                'key' => 'front_phone',
                'value' => '+1 9876543210'),
            array(
                'key' => 'front_app_language',
                'value' => 'en'),
            array(
                'key' => 'front_timezone',
                'value' => 'Africa/Cairo'),
            array(
                'key' => 'front_country_code',
                'value' => '+20'),
            array(
                'key' => 'google_geocoding_api_key',
                'value' => 'AIzaSyDmuQZuyvtLoog7Yi_s48Gwj4Y3vTT6PKs'),
            array(
                'key' => 'max_order_kms',
                'value' => '10'),
            array(
                'key' => 'front_stripe_key',
                'value' => 'pk_test_rqXwj4cHIkc7bp74WvII9YCF00ArTr5Asu'),
            array(
                'key' => 'front_stripe_secret',
                'value' => 'sk_test_kx9OmxdcMuxaubTeUGchEyg100hPynGXYK'),
            array(
                'key' => 'front_fixed_shipping',
                'value' => '50'),
            array(
                'key' => 'front_extra_km_charges',
                'value' => '10'),
            array(
                'key' => 'front_service_charges',
                'value' => '5'),
            array(
                'key' => 'front_driver_share',
                'value' => '80'),
        );

        \DB::table('app_settings')->insert($app_settings); 
      // Logo settings
      // Logo and Icons
      $images = [
        [
          'settings' => 'admin_logo',
          'collection' => 'admin_logo',
          'url' => public_path('defaults/imports/abboda-logo-admin.png'),
          'relate' => [],
        ],
        [
          'settings' => 'front_logo',
          'collection' => 'front_logo',
          'url' => public_path('defaults/imports/abboda-logo-front.png'),
          'relate' => [],
        ],
        [
          'settings' => 'icon_logo',
          'collection' => 'icon_logo',
          'url' => public_path('defaults/imports/icon.png'),
          'relate' => [],
        ],
        [
          'settings' => '',
          'collection' => 'avatar',
          'url' => public_path('defaults/imports/admin.png'),
          'relate' => [
            'model' => (new \App\User),
            'id' => 1
          ],
        ],

      ];


      foreach ($images as $image)
      {
        $upObj = new \App\Models\Upload;
        $upObj->uuid = Front::myUploadId(); // get uuid
        $upObj->save();
        $upObj->addMediaFromUrl($image['url']) //  Full Url
            ->withCustomProperties(['uuid' => $upObj->uuid])
            ->toMediaCollection($image['collection']);
        if($image['settings']) 
        {
          \DB::table('app_settings')->insert([
            'key' => $image['settings'],
            'value' => $upObj->uuid
            ]); 
        }
        if($image['relate'])
        {
          $model = $image['relate']['model']::where('id',$image['relate']['id'])->first();
          if(!is_null($model))
          {
            $media = $upObj->getMedia($image['collection'])->first();
            $media->copy($model, $image['collection']);
          }
        }
      }


    }
}
