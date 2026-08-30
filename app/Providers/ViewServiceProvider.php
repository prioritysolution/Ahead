<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.sidebar', function ($view) {
            // Fetch menu data from DB
            $menue = DB::select("CALL usp_VwMenus(?);",[Session::get('User_Grp') ?? 0]);
            $menus = collect($menue);

            // Group by Module, Parent, Child
            $grouped = $menus->groupBy('ModlId')->map(function ($moduleItems) {
                return [
                    'module_name' => $moduleItems->first()->ModName,
                    'parents' => $moduleItems->groupBy('PMnuId')->map(function ($parentItems) {
                        return [
                            'parent_name' => $parentItems->first()->PMnuNm,
                            'children' => $parentItems->groupBy('ChldMnuId')->map(function ($childItems) {
                                $child = [
                                    'child_name' => $childItems->first()->ChldMnuNm,
                                    'route' => $childItems->first()->MnuNav,
                                    'sub_children' => $childItems->filter(fn($i) => $i->SChldMnuId != null)
                                        ->map(function ($sub) {
                                            return [
                                                'sub_id' => $sub->SChldMnuId,
                                                'sub_name' => $sub->SChldMnuNm,
                                                'route' => $sub->MnuNav,
                                            ];
                                        })->values()
                                ];
                                return $child;
                            })->values()
                        ];
                    })->values()
                ];
            });

            // Share the menu with sidebar view
            $view->with('menue', $grouped);
        });
    }
}
