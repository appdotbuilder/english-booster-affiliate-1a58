import React from 'react';
import { Head, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

interface AffiliateLink {
    id: number;
    tracking_code: string;
    link_url: string;
    clicks: number;
    created_at: string;
    program: {
        id: number;
        name: string;
        category: string;
        price: number;
        commission_percentage: number;
    };
}

interface Sale {
    id: number;
    customer_name: string;
    sale_amount: number;
    commission_amount: number;
    status: string;
    sale_date: string;
    program: {
        name: string;
    };
}

interface Program {
    id: number;
    name: string;
    category: string;
    price: number;
    commission_percentage: number;
    description: string;
}

interface Props {
    stats: {
        totalSales: number;
        totalCommission: number;
        pendingCommission: number;
        totalClicks: number;
    };
    recentSales: Sale[];
    affiliateLinks: AffiliateLink[];
    availablePrograms: Program[];
    [key: string]: unknown;
}

export default function AffiliateDashboard({ 
    stats, 
    recentSales, 
    affiliateLinks, 
    availablePrograms 
}: Props) {
    const handleCreateLink = (programId: number) => {
        router.post(route('affiliate.store'), { program_id: programId }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const copyToClipboard = (text: string) => {
        navigator.clipboard.writeText(text);
        // You could add a toast notification here
    };

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

    const getCategoryIcon = (category: string) => {
        const icons = {
            online: '📱',
            offline_pare: '🏢',
            group: '👥',
            branch: '🏛️'
        };
        return icons[category as keyof typeof icons] || '📚';
    };

    return (
        <AppShell>
            <Head title="Affiliate Dashboard" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
                            🚀 Affiliate Dashboard
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400 mt-1">
                            Track your performance and manage your affiliate links
                        </p>
                    </div>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Total Sales</p>
                                <p className="text-2xl font-bold text-gray-900 dark:text-white">
                                    {stats.totalSales}
                                </p>
                            </div>
                            <div className="text-2xl">💰</div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Total Commission</p>
                                <p className="text-2xl font-bold text-green-600">
                                    {formatCurrency(stats.totalCommission)}
                                </p>
                            </div>
                            <div className="text-2xl">💎</div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Pending Commission</p>
                                <p className="text-2xl font-bold text-yellow-600">
                                    {formatCurrency(stats.pendingCommission)}
                                </p>
                            </div>
                            <div className="text-2xl">⏳</div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-400">Total Clicks</p>
                                <p className="text-2xl font-bold text-blue-600">
                                    {stats.totalClicks}
                                </p>
                            </div>
                            <div className="text-2xl">👆</div>
                        </div>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Affiliate Links */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                                🔗 Your Affiliate Links
                            </h2>
                        </div>
                        <div className="p-6 space-y-4">
                            {affiliateLinks.length > 0 ? (
                                affiliateLinks.map((link) => (
                                    <div key={link.id} className="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                        <div className="flex items-start justify-between mb-2">
                                            <div>
                                                <h3 className="font-medium text-gray-900 dark:text-white">
                                                    {getCategoryIcon(link.program.category)} {link.program.name}
                                                </h3>
                                                <p className="text-sm text-gray-600 dark:text-gray-400">
                                                    Commission: {link.program.commission_percentage}% • Clicks: {link.clicks}
                                                </p>
                                            </div>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <input
                                                type="text"
                                                value={link.link_url}
                                                readOnly
                                                className="flex-1 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded px-3 py-2"
                                            />
                                            <button
                                                onClick={() => copyToClipboard(link.link_url)}
                                                className="px-3 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors"
                                            >
                                                📋
                                            </button>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <p className="text-gray-500 text-center py-8">
                                    No affiliate links yet. Create your first link below! 👇
                                </p>
                            )}
                        </div>
                    </div>

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
                                    {recentSales.map((sale) => (
                                        <div key={sale.id} className="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                            <div>
                                                <p className="font-medium text-gray-900 dark:text-white">
                                                    {sale.customer_name}
                                                </p>
                                                <p className="text-sm text-gray-600 dark:text-gray-400">
                                                    {sale.program.name}
                                                </p>
                                            </div>
                                            <div className="text-right">
                                                <p className="font-medium text-gray-900 dark:text-white">
                                                    {formatCurrency(sale.commission_amount)}
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
                                    No sales yet. Start promoting your links! 📢
                                </p>
                            )}
                        </div>
                    </div>
                </div>

                {/* Available Programs */}
                {availablePrograms.length > 0 && (
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                                ➕ Create New Affiliate Links
                            </h2>
                        </div>
                        <div className="p-6">
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                {availablePrograms.map((program) => (
                                    <div key={program.id} className="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                        <div className="mb-3">
                                            <h3 className="font-medium text-gray-900 dark:text-white">
                                                {getCategoryIcon(program.category)} {program.name}
                                            </h3>
                                            <p className="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                {program.description}
                                            </p>
                                        </div>
                                        <div className="flex items-center justify-between mb-3">
                                            <span className="text-sm font-medium text-green-600">
                                                {program.commission_percentage}% Commission
                                            </span>
                                            <span className="text-sm text-gray-600 dark:text-gray-400">
                                                {formatCurrency(program.price)}
                                            </span>
                                        </div>
                                        <button
                                            onClick={() => handleCreateLink(program.id)}
                                            className="w-full px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors"
                                        >
                                            Create Link
                                        </button>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </AppShell>
    );
}