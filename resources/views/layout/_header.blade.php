<header>
    <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <a href="{{ route('welcome') }}" class="flex items-center">
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Subscription tracker</span>
            </a>
            <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
{{--                    <li>--}}
{{--                        <a href="{{ route('account') }}"--}}
{{--                           class="block py-2 pr-4 pl-3 text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0 dark:text-white"--}}
{{--                           >Account</a>--}}
{{--                    </li>--}}

                    <li>
                        <a href="{{ route('subscriptions.index') }}"
                           class="block py-2 pr-4 pl-3 text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0 dark:text-white"
                           >Subscriptions</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
