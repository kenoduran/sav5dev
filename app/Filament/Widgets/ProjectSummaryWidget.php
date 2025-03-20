<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectSummaryWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $totalProjects = Project::count();
        $inProgressProjects = Project::where('status', 'In Progress')->count();
        $totalBudget = Project::sum('total_budget');
        $totalCost = Project::sum('current_cost');
        
        // Calculate average project completion
        $avgProgress = Project::avg('progress_percentage');
        
        // Projects that are overdue
        $overdueProjects = Project::whereDate('estimated_end_date', '<', now())
            ->whereNotIn('status', ['Completed', 'Cancelled'])
            ->count();
        
        // Projects to start this month
        $startingThisMonth = Project::whereYear('estimated_start_date', now()->year)
            ->whereMonth('estimated_start_date', now()->month)
            ->whereNull('actual_start_date')
            ->count();
            
        // Calculate current financial performance
        $profitMargin = $totalBudget > 0 ? (($totalBudget - $totalCost) / $totalBudget) * 100 : 0;
        
        return [
            Stat::make('Total Projects', $totalProjects)
                ->description('All registered projects')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('primary'),
                
            Stat::make('In Progress', $inProgressProjects)
                ->description('Active projects')
                ->descriptionIcon('heroicon-m-play')
                ->color('info'),
                
            Stat::make('Average Progress', number_format($avgProgress, 1) . '%')
                ->description('Current average completion')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),
                
            Stat::make('Total Budget', '$' . number_format($totalBudget, 2))
                ->description('All projects combined')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
                
            Stat::make('Total Cost', '$' . number_format($totalCost, 2))
                ->description('Current expenses')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),
                
            Stat::make('Profit Margin', number_format($profitMargin, 1) . '%')
                ->description('Current financial performance')
                ->descriptionIcon('heroicon-m-presentation-chart-line')
                ->color($profitMargin > 0 ? 'success' : 'danger'),
                
            Stat::make('Overdue Projects', $overdueProjects)
                ->description('Past expected end date')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($overdueProjects > 0 ? 'danger' : 'success'),
                
            Stat::make('Starting This Month', $startingThisMonth)
                ->description('Projects to begin soon')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
        ];
    }
}