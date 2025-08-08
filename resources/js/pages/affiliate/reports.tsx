import React from 'react';
import { Head } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

interface Sale {
    id: number;
    customer_name: string;
    customer_email: string;
    sale_amount: number;
    commission_amount: number;
    status: string;
    sale_date: string;
    program: {
        name: string;
        category: string;
    };
}

interface MonthlyCommission {
    year: number;
    month: number;
    total: number;
}

interface Props {
    sales: {
        data: Sale[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    monthlyCommissions: MonthlyCommission[];
    [key: string]: unknown;
}

export default function AffiliateReports({ sales, monthlyCommissions }: Props) {
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

    const getMonthName = (month: number) => {
        const months = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
        return months[month - 1];
    };

    return (
        <AppShell>
            <Head title="Commission Reports" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
                            📊 Commission Reports
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400 mt-1">
                            Detailed breakdown of your earnings and sales performance
                        </p>
                    </div>
                </div>

                {/* Monthly Commission Chart */}
                {monthlyCommissions.length > 0 && (
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                                📈 Monthly Commission Trend
                            </h2>
                        </div>
                        <div className="p-6">
                            <div className="flex flex-wrap gap-4">
                                {monthlyCommissions.map((item, index) => (
                                    <div key={index} className="flex-1 min-w-32 text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div className="text-sm text-gray-600 dark:text-gray-400">
                                            {getMonthName(item.month)} {item.year}
                                        </div>
                                        <div className="text-lg font-bold text-green-600">
                                            {formatCurrency(item.total)}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                )}

                {/* Sales Details */}
                <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                            💰 Sales Details
                        </h2>
                        <p className="text-gray-600 dark:text-gray-400 mt-1">
                            Complete history of your referred sales
                        </p>
                    </div>
                    <div className="overflow-x-auto">
                        <table className="w-full">
                            <thead className="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Customer
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Program
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Sale Amount
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Commission
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200 dark:divide-gray-700">
                                {sales.data.length > 0 ? (
                                    sales.data.map((sale) => (
                                        <tr key={sale.id}>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <div>
                                                    <div className="font-medium text-gray-900 dark:text-white">
                                                        {sale.customer_name}
                                                    </div>
                                                    <div className="text-sm text-gray-600 dark:text-gray-400">
                                                        {sale.customer_email}
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <div className="flex items-center">
                                                    <span className="mr-2">
                                                        {getCategoryIcon(sale.program.category)}
                                                    </span>
                                                    <span className="text-gray-900 dark:text-white">
                                                        {sale.program.name}
                                                    </span>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white font-medium">
                                                {formatCurrency(sale.sale_amount)}
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-green-600 font-medium">
                                                {formatCurrency(sale.commission_amount)}
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <span className={`inline-block px-2 py-1 text-xs rounded-full ${getStatusBadge(sale.status)}`}>
                                                    {sale.status}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                {new Date(sale.sale_date).toLocaleDateString()}
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan={6} className="px-6 py-8 text-center text-gray-500">
                                            No sales recorded yet. Start promoting your affiliate links! 🚀
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>

                    {/* Pagination would go here if needed */}
                    {sales.last_page > 1 && (
                        <div className="p-6 border-t border-gray-200 dark:border-gray-700">
                            <div className="flex items-center justify-between">
                                <div className="text-sm text-gray-600 dark:text-gray-400">
                                    Showing {((sales.current_page - 1) * sales.per_page) + 1} to {Math.min(sales.current_page * sales.per_page, sales.total)} of {sales.total} results
                                </div>
                                <div className="flex gap-2">
                                    {sales.current_page > 1 && (
                                        <a
                                            href={`?page=${sales.current_page - 1}`}
                                            className="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 rounded hover:bg-gray-200 dark:hover:bg-gray-600"
                                        >
                                            Previous
                                        </a>
                                    )}
                                    {sales.current_page < sales.last_page && (
                                        <a
                                            href={`?page=${sales.current_page + 1}`}
                                            className="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 rounded hover:bg-gray-200 dark:hover:bg-gray-600"
                                        >
                                            Next
                                        </a>
                                    )}
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AppShell>
    );
}