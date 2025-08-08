import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="English Booster - Affiliate System">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col items-center bg-gradient-to-br from-blue-50 to-indigo-100 p-6 text-gray-900 lg:justify-center lg:p-8 dark:from-gray-900 dark:to-blue-900 dark:text-white">
                <header className="mb-8 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-6xl">
                    <nav className="flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white font-bold text-sm">
                                EB
                            </div>
                            <span className="font-semibold text-lg">English Booster</span>
                        </div>
                        <div className="flex items-center gap-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="inline-block rounded-lg border border-blue-200 bg-white px-5 py-2 text-sm font-medium text-blue-700 shadow-sm transition-all hover:bg-blue-50 hover:border-blue-300 dark:bg-gray-800 dark:border-gray-600 dark:text-blue-400 dark:hover:bg-gray-700"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="inline-block rounded-lg px-5 py-2 text-sm font-medium text-gray-700 transition-all hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="inline-block rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white shadow-sm transition-all hover:bg-blue-700 hover:shadow-md"
                                    >
                                        Join as Affiliate
                                    </Link>
                                </>
                            )}
                        </div>
                    </nav>
                </header>

                <div className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow">
                    <main className="flex w-full max-w-[335px] flex-col lg:max-w-6xl lg:flex-row lg:gap-12">
                        {/* Hero Content */}
                        <div className="flex-1 flex flex-col justify-center">
                            <div className="text-center lg:text-left mb-8 lg:mb-0">
                                <h1 className="mb-6 text-4xl lg:text-6xl font-bold leading-tight">
                                    🚀 Earn with 
                                    <span className="block text-blue-600 dark:text-blue-400">English Booster</span>
                                    Affiliate Program
                                </h1>
                                
                                <p className="mb-8 text-xl lg:text-2xl text-gray-600 dark:text-gray-300 leading-relaxed">
                                    Join thousands of partners earning commission by promoting Indonesia's leading English language courses
                                </p>

                                <div className="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start mb-8">
                                    {!auth.user && (
                                        <>
                                            <Link
                                                href={route('register')}
                                                className="inline-flex items-center justify-center rounded-xl bg-blue-600 px-8 py-4 text-lg font-semibold text-white shadow-lg transition-all hover:bg-blue-700 hover:shadow-xl hover:scale-105"
                                            >
                                                💰 Start Earning Today
                                            </Link>
                                            <Link
                                                href={route('login')}
                                                className="inline-flex items-center justify-center rounded-xl border-2 border-blue-600 px-8 py-4 text-lg font-semibold text-blue-600 transition-all hover:bg-blue-600 hover:text-white"
                                            >
                                                🔑 Affiliate Login
                                            </Link>
                                        </>
                                    )}
                                    {auth.user && (
                                        <Link
                                            href={route('dashboard')}
                                            className="inline-flex items-center justify-center rounded-xl bg-blue-600 px-8 py-4 text-lg font-semibold text-white shadow-lg transition-all hover:bg-blue-700 hover:shadow-xl hover:scale-105"
                                        >
                                            📊 Go to Dashboard
                                        </Link>
                                    )}
                                </div>
                            </div>
                        </div>

                        {/* Features Grid */}
                        <div className="flex-1">
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-6 lg:gap-8">
                                <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800 transition-all hover:shadow-xl hover:scale-105">
                                    <div className="mb-4 text-4xl">🎯</div>
                                    <h3 className="mb-2 text-xl font-bold">Unique Tracking Links</h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        Get personalized tracking links for all English Booster programs and monitor your referrals in real-time
                                    </p>
                                </div>

                                <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800 transition-all hover:shadow-xl hover:scale-105">
                                    <div className="mb-4 text-4xl">📈</div>
                                    <h3 className="mb-2 text-xl font-bold">Real-time Analytics</h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        Track clicks, conversions, and earnings with detailed analytics and performance insights
                                    </p>
                                </div>

                                <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800 transition-all hover:shadow-xl hover:scale-105">
                                    <div className="mb-4 text-4xl">💎</div>
                                    <h3 className="mb-2 text-xl font-bold">High Commissions</h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        Earn competitive commissions up to 25% on all English course sales from your referrals
                                    </p>
                                </div>

                                <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800 transition-all hover:shadow-xl hover:scale-105">
                                    <div className="mb-4 text-4xl">🏆</div>
                                    <h3 className="mb-2 text-xl font-bold">Multiple Programs</h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        Promote 15+ programs including TOEFL, Kids English, Speaking Booster, and more
                                    </p>
                                </div>
                            </div>

                            {/* Program Categories */}
                            <div className="mt-8 rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                <h3 className="mb-4 text-2xl font-bold text-center">🎓 Available Programs</h3>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 className="font-semibold text-blue-600 mb-2">📱 Online Programs</h4>
                                        <ul className="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                            <li>• Kids English</li>
                                            <li>• Teen English</li>
                                            <li>• TOEFL Easy Peasy</li>
                                            <li>• Private General English</li>
                                            <li>• Speaking Booster</li>
                                            <li>• Grammar Booster</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 className="font-semibold text-green-600 mb-2">🏢 Offline Programs (Pare)</h4>
                                        <ul className="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                            <li>• Paket 2 minggu</li>
                                            <li>• Paket 1 bulan</li>
                                            <li>• Paket 2 bulan</li>
                                            <li>• Paket 3 bulan</li>
                                            <li>• TOEFL RPL</li>
                                            <li>• Kapal Pesiar</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>

                <footer className="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                    <p>🌟 Join over 1,000+ active affiliates earning with English Booster</p>
                    <p className="mt-2">Built with ❤️ for English education in Indonesia</p>
                </footer>
            </div>
        </>
    );
}