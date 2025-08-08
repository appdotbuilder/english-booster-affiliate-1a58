import React from 'react';
import { Head, Link } from '@inertiajs/react';

interface Program {
    id: number;
    name: string;
    description: string;
    category: string;
    location: string | null;
    price: number;
    commission_percentage: number;
    is_active: boolean;
}

interface Props {
    program: Program;
    trackingCode: string;
    [key: string]: unknown;
}

export default function ProgramDetails({ program, trackingCode }: Props) {
    const formatCurrency = (amount: number) => {
        return `Rp ${new Intl.NumberFormat('id-ID').format(amount)}`;
    };

    const getCategoryInfo = (category: string) => {
        const categories = {
            online: { icon: '📱', name: 'Online Program', color: 'blue' },
            offline_pare: { icon: '🏢', name: 'Offline Program (Pare)', color: 'green' },
            group: { icon: '👥', name: 'Group Program', color: 'purple' },
            branch: { icon: '🏛️', name: 'Branch Program', color: 'orange' }
        };
        return categories[category as keyof typeof categories] || { icon: '📚', name: 'Program', color: 'gray' };
    };

    const categoryInfo = getCategoryInfo(program.category);

    return (
        <>
            <Head title={`${program.name} - English Booster`} />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-blue-900">
                {/* Header */}
                <header className="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                        <div className="flex items-center justify-between">
                            <div className="flex items-center gap-2">
                                <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white font-bold text-sm">
                                    EB
                                </div>
                                <span className="font-semibold text-lg text-gray-900 dark:text-white">English Booster</span>
                            </div>
                            <div className="flex items-center gap-4">
                                <Link
                                    href={route('home')}
                                    className="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400"
                                >
                                    Home
                                </Link>
                                <Link
                                    href={route('login')}
                                    className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                                >
                                    Join as Affiliate
                                </Link>
                            </div>
                        </div>
                    </div>
                </header>

                {/* Main Content */}
                <main className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    {/* Referral Notice */}
                    <div className="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                        <div className="flex items-center gap-2 text-green-800 dark:text-green-200">
                            <span className="text-xl">🎉</span>
                            <p className="font-medium">
                                You've been referred by one of our trusted affiliates! 
                                <span className="ml-2 px-2 py-1 text-xs bg-green-100 dark:bg-green-800 rounded">
                                    Tracking: {trackingCode}
                                </span>
                            </p>
                        </div>
                    </div>

                    {/* Program Details Card */}
                    <div className="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        {/* Header */}
                        <div className="p-8 border-b border-gray-200 dark:border-gray-700">
                            <div className="flex items-start justify-between">
                                <div>
                                    <div className="flex items-center gap-3 mb-3">
                                        <span className="text-3xl">{categoryInfo.icon}</span>
                                        <div>
                                            <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
                                                {program.name}
                                            </h1>
                                            <div className={`inline-block px-3 py-1 text-sm rounded-full bg-${categoryInfo.color}-100 text-${categoryInfo.color}-800 dark:bg-${categoryInfo.color}-900/20 dark:text-${categoryInfo.color}-200`}>
                                                {categoryInfo.name}
                                            </div>
                                        </div>
                                    </div>
                                    {program.location && (
                                        <div className="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                            <span>📍</span>
                                            <span>{program.location}</span>
                                        </div>
                                    )}
                                </div>
                                <div className="text-right">
                                    <div className="text-3xl font-bold text-blue-600">
                                        {formatCurrency(program.price)}
                                    </div>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">Program Fee</p>
                                </div>
                            </div>
                        </div>

                        {/* Content */}
                        <div className="p-8">
                            <div className="space-y-6">
                                {/* Description */}
                                <div>
                                    <h2 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                        📝 Program Description
                                    </h2>
                                    <p className="text-gray-600 dark:text-gray-400 leading-relaxed">
                                        {program.description || 'This comprehensive English program is designed to help you achieve your language learning goals with expert instruction and proven methodologies.'}
                                    </p>
                                </div>

                                {/* Features based on category */}
                                <div>
                                    <h2 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                        ✨ Program Features
                                    </h2>
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        {program.category === 'online' && (
                                            <>
                                                <div className="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                                    <span className="text-blue-600">💻</span>
                                                    <span>Interactive Online Classes</span>
                                                </div>
                                                <div className="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                                    <span className="text-blue-600">📱</span>
                                                    <span>Mobile App Access</span>
                                                </div>
                                                <div className="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                                    <span className="text-blue-600">🎯</span>
                                                    <span>Personalized Learning Path</span>
                                                </div>
                                                <div className="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                                    <span className="text-blue-600">📊</span>
                                                    <span>Progress Tracking</span>
                                                </div>
                                            </>
                                        )}
                                        {program.category === 'offline_pare' && (
                                            <>
                                                <div className="flex items-center gap-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                                    <span className="text-green-600">🏢</span>
                                                    <span>Physical Classroom Setting</span>
                                                </div>
                                                <div className="flex items-center gap-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                                    <span className="text-green-600">👥</span>
                                                    <span>Small Class Sizes</span>
                                                </div>
                                                <div className="flex items-center gap-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                                    <span className="text-green-600">🏠</span>
                                                    <span>Accommodation Assistance</span>
                                                </div>
                                                <div className="flex items-center gap-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                                    <span className="text-green-600">🌟</span>
                                                    <span>Immersive Environment</span>
                                                </div>
                                            </>
                                        )}
                                        {(program.category === 'group' || program.category === 'branch') && (
                                            <>
                                                <div className="flex items-center gap-3 p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                                    <span className="text-purple-600">👥</span>
                                                    <span>Group Learning Experience</span>
                                                </div>
                                                <div className="flex items-center gap-3 p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                                    <span className="text-purple-600">🎪</span>
                                                    <span>Fun & Interactive Activities</span>
                                                </div>
                                                <div className="flex items-center gap-3 p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                                    <span className="text-purple-600">📍</span>
                                                    <span>Local Branch Support</span>
                                                </div>
                                                <div className="flex items-center gap-3 p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                                    <span className="text-purple-600">🏆</span>
                                                    <span>Achievement Certificates</span>
                                                </div>
                                            </>
                                        )}
                                    </div>
                                </div>

                                {/* Call to Action */}
                                <div className="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 text-center">
                                    <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-3">
                                        🚀 Ready to Start Your English Journey?
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-400 mb-6">
                                        Join thousands of students who have improved their English with our proven programs
                                    </p>
                                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                        <a
                                            href="https://wa.me/6281234567890"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="inline-flex items-center justify-center px-8 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition-colors"
                                        >
                                            💬 Contact via WhatsApp
                                        </a>
                                        <a
                                            href="tel:+6281234567890"
                                            className="inline-flex items-center justify-center px-8 py-3 border-2 border-blue-600 text-blue-600 rounded-xl font-semibold hover:bg-blue-600 hover:text-white transition-colors"
                                        >
                                            📞 Call Now
                                        </a>
                                    </div>
                                    <p className="text-sm text-gray-500 dark:text-gray-400 mt-4">
                                        Mention tracking code: <span className="font-mono font-bold">{trackingCode}</span> when registering
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Trust Indicators */}
                    <div className="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 text-center shadow-sm border border-gray-200 dark:border-gray-700">
                            <div className="text-3xl mb-3">🏆</div>
                            <h3 className="font-semibold text-gray-900 dark:text-white">10+ Years Experience</h3>
                            <p className="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                Trusted English education provider
                            </p>
                        </div>
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 text-center shadow-sm border border-gray-200 dark:border-gray-700">
                            <div className="text-3xl mb-3">👥</div>
                            <h3 className="font-semibold text-gray-900 dark:text-white">50,000+ Students</h3>
                            <p className="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                Successfully trained students
                            </p>
                        </div>
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 text-center shadow-sm border border-gray-200 dark:border-gray-700">
                            <div className="text-3xl mb-3">⭐</div>
                            <h3 className="font-semibold text-gray-900 dark:text-white">4.8/5 Rating</h3>
                            <p className="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                Average student satisfaction
                            </p>
                        </div>
                    </div>
                </main>
            </div>
        </>
    );
}