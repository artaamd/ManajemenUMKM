<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('layouts.app', function ($view) {
            $user = auth()->user();
            $content_trends = [
                'instagram' => [],
                'facebook' => [],
                'labels' => [],
            ];

            if ($user && $user->role === 'umkm') {
                // Ambil tren jumlah konten per bulan (6 bulan terakhir)
                $startDate = now()->subMonths(5)->startOfMonth();
                $endDate = now()->endOfMonth();
                $months = collect();
                $currentDate = $startDate->copy();

                while ($currentDate <= $endDate) {
                    $months->push($currentDate->format('M Y'));
                    $currentDate->addMonth();
                }

                $content_trends['labels'] = $months->toArray();

                // Data untuk Instagram
                $content_trends['instagram'] = $months->map(function ($month) use ($user) {
                    $monthDate = \Carbon\Carbon::createFromFormat('M Y', $month);
                    return $user->kontens()
                        ->where('platform', 'instagram')
                        ->whereYear('created_at', $monthDate->year)
                        ->whereMonth('created_at', $monthDate->month)
                        ->count();
                })->toArray();

                // Data untuk Facebook
                $content_trends['facebook'] = $months->map(function ($month) use ($user) {
                    $monthDate = \Carbon\Carbon::createFromFormat('M Y', $month);
                    return $user->kontens()
                        ->where('platform', 'facebook')
                        ->whereYear('created_at', $monthDate->year)
                        ->whereMonth('created_at', $monthDate->month)
                        ->count();
                })->toArray();
            }

            $view->with('content_trends', $content_trends);
        });
    }
}