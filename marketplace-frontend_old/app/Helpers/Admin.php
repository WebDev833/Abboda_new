<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Admin
{
    public static function statusColumn($column, $attributeName = 'status',$text = ["true"=>"Active","false"=>"Inactive"])
    {
        if (isset($column)) {
            if ($column[$attributeName]) {
                return "<span class='badge badge-success'>" . $text['true'] . "</span>";
            } else {
                return "<span class='badge badge-danger'>" . $text['false'] . "</span>";
            }
        }
    }

    public static function badgeColumn($text = '', $class = 'badge-danger')
    {
        if (isset($text)) {
                return "<span class='badge ".$class."'>" . $text . "</span>";
        }
    }

    public static function priceColumn($price = '', $space = true)
    {
      //return self::badgeColumn(romsProPrice($price,$space),'badge-primary');
      return romsProPrice($price,$space);
    }

    public static function dateColumn($modelObject, $attributeName = 'updated_at')
    {
        if (setting('is_human_date_format', false)) {
            $html = '<span data-toggle="tooltip" data-placement="bottom" title="${date}">${dateHuman}</span>';
        } else {
            $html = '<span data-toggle="tooltip" data-placement="bottom" title="${dateHuman}">${date}</span>';
        }
        if (!isset($modelObject[$attributeName])) {
            return '';
        }
        $dateObj = new \Carbon\Carbon($modelObject[$attributeName]);
        $replace = preg_replace('/\$\{date\}/', $dateObj->format(setting('date_format', 'l jS F Y (h:i:s)')), $html);
        $replace = preg_replace('/\$\{dateHuman\}/', $dateObj->diffForHumans(), $replace);
        return $replace;
    }

    public static function tableActions($elems = [])
    {
        $string = '<div class="justify-content-center text-center d-flex">';

        if (isset($elems['view']['view'])) {
            $string .= '<a href="' . $elems['view']['link'] . '" class="ripple btn-primary btn-icon mr-3" data-placement="bottom" data-toggle="tooltip" title="View"><i class="fe fe-eye"></i></a>';
        }

        if (isset($elems['edit']['view'])) {
            $string .= '<a href="' . $elems['edit']['link'] . '" class="ripple btn-secondary btn-icon mr-3" data-placement="bottom" data-toggle="tooltip" title="Edit"><i class="fe fe-edit-2"></i></a>';
        }

        if (isset($elems['delete']['view'])) {
            $string .= '<a href="' . $elems['delete']['link'] . '" class="ripple btn-danger btn-icon" data-placement="bottom" data-toggle="tooltip" title="Delete">
          <i class="fe fe-trash-2"></i>
        </a>';
        }

        $string .= '</div>';
        return $string;
    }

    public static function slugColumn($link = '#', $text = 'View', $target = "_blank")
    {
        return '<a href="' . $link . '" class="btn ripple btn-primary btn-sm" target="' . $target . '">' . $text . '</a>';
    }

    public static function stringColumn($string = '', $limit = 30, $endwith = " ...")
    {
        $template = '<span>${text}</span>';
        $truncated = Str::limit($string, $limit, $endwith);
        $replace = preg_replace('/\$\{text\}/', $truncated, $template);
        return $replace;
    }

    public static function getByUuid($uuid = '')
    {
        $uploadModel = \App\Models\Upload::query()->where('uuid', $uuid)->first();
        return $uploadModel;
    }

    /**
     * Remove Model Media
     */
    public static function removeModelMedia($model, $id, $collection)
    {
        if ($m = $model->find($id)) {

            if ($m->hasMedia($collection)) {
                $m->getFirstMedia($collection)->delete();
                return true;
            }
            return true;
        }
        return false;
    }

    /**
     * Time 30 minute step array
     */
    public static function timeArray()
    {
        return [
            "00:00" => "00:00",
            "00:30" => "00:30",
            "01:00" => "01:00",
            "01:30" => "01:30",
            "02:00" => "02:00",
            "02:30" => "02:30",
            "03:00" => "03:00",
            "03:30" => "03:30",
            "04:00" => "04:00",
            "04:30" => "04:30",
            "05:00" => "05:00",
            "05:30" => "05:30",
            "06:00" => "06:00",
            "06:30" => "06:30",
            "07:00" => "07:00",
            "07:30" => "07:30",
            "08:00" => "08:00",
            "08:30" => "08:30",
            "09:00" => "09:00",
            "09:30" => "09:30",
            "10:00" => "10:00",
            "10:30" => "10:30",
            "11:00" => "11:00",
            "11:30" => "11:30",
            "12:00" => "12:00",
            "12:30" => "12:30",
            "13:00" => "13:00",
            "13:30" => "13:30",
            "14:00" => "14:00",
            "14:30" => "14:30",
            "15:00" => "15:00",
            "15:30" => "15:30",
            "16:00" => "16:00",
            "16:30" => "16:30",
            "17:00" => "17:00",
            "17:30" => "17:30",
            "18:00" => "18:00",
            "18:30" => "18:30",
            "19:00" => "19:00",
            "19:30" => "19:30",
            "20:00" => "20:00",
            "20:30" => "20:30",
            "21:00" => "21:00",
            "21:30" => "21:30",
            "22:00" => "22:00",
            "22:30" => "22:30",
            "23:00" => "23:00",
            "23:30" => "23:30",
        ];
    }
}
