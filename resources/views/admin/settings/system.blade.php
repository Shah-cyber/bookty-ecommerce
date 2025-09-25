@extends('layouts.admin')

@section('header', 'System Preference')

@section('content')
    <div class="max-w-xl bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Theme</h2>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Choose your preferred appearance for the admin dashboard.</p>

        <div class="space-y-3">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="radio" name="themePreference" value="light" class="h-4 w-4" />
                <span class="text-gray-900 dark:text-gray-100">Light Theme</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="radio" name="themePreference" value="dark" class="h-4 w-4" />
                <span class="text-gray-900 dark:text-gray-100">Dark Mode</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="radio" name="themePreference" value="system" class="h-4 w-4" />
                <span class="text-gray-900 dark:text-gray-100">Follow system preference</span>
            </label>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button id="saveThemePref" class="px-4 py-2 bg-bookty-purple-600 text-white rounded hover:bg-bookty-purple-700">Save</button>
            <span id="themeSavedMsg" class="hidden text-sm text-green-600">Saved!</span>
        </div>
    </div>

    <script>
        (function() {
            const storageKey = 'themePreference'; // 'light' | 'dark' | 'system'
            const radios = document.querySelectorAll('input[name="themePreference"]');
            const saveBtn = document.getElementById('saveThemePref');
            const savedMsg = document.getElementById('themeSavedMsg');

            function applyTheme(pref) {
                const root = document.documentElement;
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = pref === 'dark' || (pref === 'system' && prefersDark);
                root.classList.toggle('dark', isDark);
            }

            function getPref() {
                return localStorage.getItem(storageKey) || 'system';
            }

            function setPref(pref) {
                localStorage.setItem(storageKey, pref);
                applyTheme(pref);
            }

            // Initialize selection
            const current = getPref();
            radios.forEach(r => { r.checked = (r.value === current); });
            applyTheme(current);

            // Save
            saveBtn.addEventListener('click', function() {
                const selected = Array.from(radios).find(r => r.checked)?.value || 'system';
                setPref(selected);
                savedMsg.classList.remove('hidden');
                setTimeout(() => savedMsg.classList.add('hidden'), 1200);
            });

            // Listen to system changes when pref is system
            const mq = window.matchMedia('(prefers-color-scheme: dark)');
            mq.addEventListener?.('change', () => {
                if (getPref() === 'system') applyTheme('system');
            });
        })();
    </script>
@endsection


