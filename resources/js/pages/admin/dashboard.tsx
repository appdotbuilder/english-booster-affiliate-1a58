import React from 'react';
import { Head } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

interface Sale {
    id: number;
    customer_name: string;
    sale_amount: number;
    commission_amount: number;
    status: string;
    sale_date: string;
    affiliate: {
        name: string;
    };
    program: {
        name: string;
    };
}

interface Affiliate {
    id: number;
    name: string;
    email: string;
    total_sales: number;
}

interface SalesByProgram {
    name: string;
    count: number;
    total: number;
}

interface Props {
    stats: {
        totalAffiliates: number;
        totalSales: number;
        totalCommissions: number;
        pendingPayouts: number;
    };
    recentSales: Sale[];
    topAffiliates: Affiliate[];
    salesByProgram: SalesByProgram[];
    [key: string]: unknown;
}

export default function AdminDashboard({ 
    stats, 
    recentSales, 
    topAffiliates, 
    salesByProgram 
}: Props) {
    const formatCurrency = (amount: number) => {
        return `Rp ${new Intl.NumberFormat('id-ID').format(amount)}`;
    };

    const getStatusBadge = (status: string) => {
        const colors = {
            pending: 'bg-yellow-100 text-yellow-800',
            confirmed: 'bg-green-100 text-green-800',
            cancelled: 'bg-red-100 text-red-800'
        };
        return colors[status as keyof typeof colors] || 'bg-gray-100 text-gray-800';
    };

    return (
        <AppShell>
            <Head title="Admin Dashboard" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
                            👑 Admin Dashboard
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400 mt-1">
                            Manage affiliates, programs, and track overall performance
                        </p>
                    </div>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Total Affiliates</p>
                                <p className="text-2xl font-bold text-blue-600">
                                    {stats.totalAffiliates}
                                </p>
                            </div>
                            <div className="text-2xl">👥</div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Total Sales</p>
                                <p className="text-2xl font-bold text-green-600">
                                    {formatCurrency(stats.totalSales)}
                                </p>
                            </div>
                            <div className="text-2xl">💰</div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Total Commissions</p>
                                <p className="text-2xl font-bold text-purple-600">
                                    {formatCurrency(stats.totalCommissions)}
                                </p>
                            </div>
                            <div className="text-2xl">💎</div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Pending Payouts</p>
                                <p className="text-2xl font-bold text-orange-600">
                                    {formatCurrency(stats.pendingPayouts)}
                                </p>
                            </div>
                            <div className="text-2xl">⏳</div>
                        </div>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Recent Sales */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                                📊 Recent Sales
                            </h2>
                        </div>
                        <div className="p-6">
                            {recentSales.length > 0 ? (
                                <div className="space-y-4">
                                    {recentSales.slice(0, 5).map((sale) => (
                                        <div key={sale.id} className="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                            <div>
                                                <p className="font-medium text-gray-900 dark:text-white">
                                                    {sale.customer_name}
                                                </p>
                                                <p className="text-sm text-gray-600 dark:text-gray-400">
                                                    {sale.program.name} • {sale.affiliate.name}
                                                </p>
                                            </div>
                                            <div className="text-right">
                                                <p className="font-medium text-gray-900 dark:text-white">
                                                    {formatCurrency(sale.sale_amount)}
                                                </p>
                                                <span className={`inline-block px-2 py-1 text-xs rounded-full ${getStatusBadge(sale.status)}`}>
                                                    {sale.status}
                                                </span>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <p className="text-gray-500 text-center py-8">
                                    No sales recorded yet
                                </p>
                            )}
                        </div>
                    </div>

                    {/* Top Affiliates */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                                🏆 Top Performing Affiliates
                            </h2>
                        </div>
                        <div className="p-6">
                            {topAffiliates.length > 0 ? (
                                <div className="space-y-4">
                                    {topAffiliates.map((affiliate, index) => (
                                        <div key={affiliate.id} className="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                            <div className="flex items-center gap-3">
                                                <div className={`w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold ${
                                                    index === 0 ? 'bg-yellow-100 text-yellow-700' :
                                                    index === 1 ? 'bg-gray-100 text-gray-700' :
                                                    index === 2 ? 'bg-amber-100 text-amber-700' :
                                                    'bg-blue-100 text-blue-700'
                                                }`}>
                                                    {index + 1}
                                                </div>
                                                <div>
                                                    <p className="font-medium text-gray-900 dark:text-white">
                                                        {affiliate.name}
                                                    </p>
                                                    <p className="text-sm text-gray-600 dark:text-gray-400">
                                                        {affiliate.email}
                                                    </p>
                                                </div>
                                            </div>
                                            <div className="text-right">
                                                <p className="font-medium text-green-600">
                                                    {formatCurrency(affiliate.total_sales || 0)}
                                                </p>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <p className="text-gray-500 text-center py-8">
                                    No affiliate performance data yet
                                </p>
                            )}
                        </div>
                    </div>
                </div>

                {/* Sales by Program */}
                {salesByProgram.length > 0 && (
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                                📈 Sales by Program
                            </h2>
                        </div>
                        <div className="p-6">
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                {salesByProgram.slice(0, 6).map((program, index) => (
                                    <div key={index} className="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                        <h3 className="font-medium text-gray-900 dark:text-white mb-2">
                                            📚 {program.name}
                                        </h3>
                                        <div className="space-y-1">
                                            <div className="flex justify-between text-sm">
                                                <span className="text-gray-600 dark:text-gray-400">Sales:</span>
                                                <span className="font-medium">{program.count}</span>
                                            </div>
                                            <div className="flex justify-between text-sm">
                                                <span className="text-gray-600 dark:text-gray-400">Revenue:</span>
                                                <span className="font-medium text-green-600">
                                                    {formatCurrency(program.total)}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                )}

                {/* Quick Actions */}
                <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 className="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        ⚡ Quick Actions
                    </h2>
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a
                            href="/admin/affiliates"
                            className="flex items-center gap-3 p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                        >
                            <div className="text-2xl">👥</div>
                            <span className="font-medium">Manage Affiliates</span>
                        </a>
                        <a
                            href="/admin/programs"
                            className="flex items-center gap-3 p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                        >
                            <div className="text-2xl">📚</div>
                            <span className="font-medium">Manage Programs</span>
                        </a>
                        <a
                            href="/admin/sales"
                            className="flex items-center gap-3 p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                        >
                            <div className="text-2xl">💰</div>
                            <span className="font-medium">View Sales</span>
                        </a>
                        <a
                            href="/admin/reports"
                            className="flex items-center gap-3 p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                        >
                            <div className="text-2xl">📊</div>
                            <span className="font-medium">View Reports</span>
                        </a>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}