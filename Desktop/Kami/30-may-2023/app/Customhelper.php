<?php
namespace App;

use App\Models\Language;
use Illuminate\Support\Facades\DB;


class Customhelper{

static public function SupportIntToText($status)
{
        return 'Supported';
}


static public function getJeevanBlog()
  {
	$enableData = DB::table('setting_titles')->where('setting_titles.is_active', 1)
    ->where('setting_titles.is_deleted', 0)
	->where('slug','blog')->first();
	return $enableData;
  }

static public function getLanguages()
{
  $languages     = Language::where('is_active', 1)->get();
  return $languages;
}


}