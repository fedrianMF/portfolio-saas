<template>
  <header class="bg-slate-900/50 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50">
    <div class="max-w-[1600px] mx-auto p-4 md:px-8">
      <div class="flex justify-between items-center">
        <div class="flex items-center gap-4">
          <div
            class="h-10 w-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-950" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
          </div>
          <div>
            <h1
              class="text-xl md:text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-amber-400 to-orange-500">
              System Dashboard</h1>
            <p class="text-slate-500 text-xs hidden sm:block">Real-time system monitoring & management</p>
          </div>
        </div>

        <div class="flex gap-3 md:gap-6 items-center">
          <div class="text-right hidden lg:block border-r border-slate-800 pr-6 mr-2">
            <p class="text-slate-500 text-[10px] uppercase tracking-wider font-bold">System Status</p>
            <div class="flex items-center gap-2 justify-end">
              <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
              <p class="text-slate-300 font-mono text-sm">Active</p>
            </div>
          </div>

          <div class="flex items-center gap-2 md:gap-3">
            <button @click="refreshData"
              class="p-2.5 bg-slate-800/50 hover:bg-slate-700 text-slate-400 hover:text-white rounded-xl transition-all border border-slate-700/50 group"
              title="Refresh Data">
              <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 group-hover:rotate-180 transition-transform duration-500" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                  clip-rule="evenodd" />
              </svg>
            </button>

            <!-- Notification Bell (Static) -->
            <button
              class="p-2.5 bg-slate-800/50 hover:bg-slate-700 text-slate-400 hover:text-white rounded-xl transition-all border border-slate-700/50 relative">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
              <span class="absolute top-2 right-2 h-2 w-2 bg-indigo-500 rounded-full border border-slate-900"></span>
            </button>

            <!-- User Dropdown -->
            <Dropdown align="right" width="48" content-classes="py-1 bg-slate-800 border border-slate-700 shadow-2xl">
              <template #trigger>
                <button
                  class="flex items-center gap-3 p-1 pr-4 bg-slate-800/50 hover:bg-slate-700 text-slate-300 rounded-2xl transition-all border border-slate-700/50 ml-2">
                  <div
                    class="h-9 w-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-inner">
                    {{ $page.props.auth.user.name.charAt(0) }}
                  </div>
                  <div class="text-left hidden sm:block">
                    <p class="text-sm font-bold text-white leading-tight">{{ $page.props.auth.user.name }}</p>
                    <p class="text-[10px] text-slate-500 font-medium">Administrator</p>
                  </div>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd" />
                  </svg>
                </button>
              </template>

              <template #content>
                <div class="px-4 py-3 border-b border-slate-700/50">
                  <p class="text-[10px] text-slate-500 uppercase tracking-widest font-black mb-1">Authenticated as</p>
                  <p class="text-sm text-slate-200 truncate font-medium">{{ $page.props.auth.user.email }}</p>
                </div>

                <div class="p-1">
                  <DropdownLink :href="route('profile.edit')"
                    class="!text-slate-300 hover:!bg-indigo-600 hover:!text-white !rounded-lg !mx-1 !transition-all">
                    <div class="flex items-center gap-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                      </svg>
                      Account Settings
                    </div>
                  </DropdownLink>
                </div>

                <div class="border-t border-slate-700/50 my-1"></div>

                <div class="p-1">
                  <DropdownLink :href="route('logout')" method="post" as="button"
                    class="!text-red-400 hover:!bg-red-500/10 !rounded-lg !mx-1 !transition-all">
                    <div class="flex items-center gap-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                      </svg>
                      Sign Out
                    </div>
                  </DropdownLink>
                </div>
              </template>
            </Dropdown>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import Dropdown from '@Shared/Components/Ui/Dropdown.vue'
import DropdownLink from '@Shared/Components/Ui/DropdownLink.vue'

const currentTime = ref('')

const refreshData = () => {
  // Trigger refresh in parent component
  location.reload()
}

const updateTime = () => {
  const now = new Date()
  currentTime.value = now.toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
  })
}

onMounted(() => {
  updateTime()
  setInterval(updateTime, 1000)
})
</script>
