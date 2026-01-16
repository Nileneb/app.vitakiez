<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header with API Token Button -->
        <div class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div>
                <h2 class="text-2xl font-bold mb-2">Willkommen, {{ Auth::user()->name }}!</h2>
                @if($wg)
                    <p class="text-neutral-600 dark:text-neutral-400 mb-2">
                        WG-ID: <span class="font-mono font-semibold">{{ $wg->wg_id }}</span>
                    </p>
                    <p class="text-neutral-600 dark:text-neutral-400">
                        WG-Name: <span class="font-semibold">{{ $wg->wg_name }}</span>
                    </p>
                @else
                    <div class="inline-flex items-center gap-2 rounded-lg bg-amber-100 px-3 py-2 text-amber-900 dark:bg-amber-900/30 dark:text-amber-100">
                        <span class="font-semibold">Keine WG erfasst</span>
                        <span class="text-sm">Bitte erst das Formular ausfüllen – danach wird die WG hier gespeichert.</span>
                    </div>
                @endif
            </div>
            
            <!-- API Token Button -->
            <button 
                onclick="openApiTokenModal()" 
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors whitespace-nowrap"
            >
                🔑 API Tokens
            </button>
        </div>

        <!-- WG Form -->
        <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <iframe 
                src="{{ $formUrl }}" 
                class="w-full h-full min-h-[800px]"
                frameborder="0"
                title="WG Formular"
                allowfullscreen
            ></iframe>
        </div>

        <!-- Chat Support -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-xl font-semibold">Support-Chat</h3>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Probleme melden – WG-ID wird automatisch mitgeschickt.</p>
                </div>
                @if(!$wg)
                    <span class="text-xs rounded-lg bg-amber-100 text-amber-900 px-3 py-1 dark:bg-amber-900/30 dark:text-amber-100">Bitte zuerst WG anlegen</span>
                @endif
            </div>
            <div id="n8n-chat" class="min-h-[420px]"></div>
        </div>
    </div>

    <!-- API Token Modal -->
    <dialog id="apiTokenModal" class="modal">
        <div class="modal-box w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold">API Tokens</h3>
                <button 
                    onclick="document.getElementById('apiTokenModal').close()" 
                    class="btn btn-sm btn-ghost"
                >
                    ✕
                </button>
            </div>

            <!-- Display existing tokens -->
            @php
                $tokens = Auth::user()->tokens()->latest()->get();
            @endphp
            
            @if ($tokens->count() > 0)
                <div class="mb-6">
                    <h4 class="font-semibold mb-3">Active Tokens</h4>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @foreach ($tokens as $token)
                            <div class="flex items-center justify-between p-3 border border-neutral-200 dark:border-neutral-700 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-medium">{{ $token->name }}</p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                        Created: {{ $token->created_at->format('d.m.Y H:i') }}
                                        @if ($token->last_used_at)
                                            | Last used: {{ $token->last_used_at->format('d.m.Y H:i') }}
                                        @else
                                            | Never used
                                        @endif
                                    </p>
                                </div>
                                
                                <form 
                                    method="POST" 
                                    action="{{ route('settings.api-tokens.revoke', $token->id) }}" 
                                    onsubmit="return confirm('Revoke this token?')"
                                    class="ml-2"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition-colors whitespace-nowrap"
                                    >
                                        Revoke
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Create new token form -->
            <div class="border-t border-neutral-200 dark:border-neutral-700 pt-4">
                <h4 class="font-semibold mb-3">Create New Token</h4>
                
                @if (session('new_token'))
                    <div class="mb-4 p-4 border border-green-200 bg-green-50 dark:border-green-900 dark:bg-green-900/20 rounded">
                        <p class="text-sm font-semibold text-green-900 dark:text-green-100 mb-2">✅ Token Created Successfully!</p>
                        <p class="text-xs text-green-800 dark:text-green-200 mb-3">Copy this token now - you won't be able to see it again!</p>
                        <div class="bg-white dark:bg-neutral-800 p-3 rounded border border-green-300 dark:border-green-700 font-mono text-xs break-all overflow-x-auto mb-3 cursor-pointer select-all" onclick="this.select()">{{ session('new_token') }}</div>
                        <p class="text-xs text-green-700 dark:text-green-300">
                            💡 <strong>Use in n8n:</strong><br/>
                            <code class="bg-green-100 dark:bg-green-900 px-2 py-1 rounded block mt-1 break-all">Authorization: Bearer {{ session('new_token') }}</code>
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('settings.api-tokens.create') }}" class="flex gap-2 flex-col sm:flex-row">
                    @csrf
                    
                    <input 
                        type="text" 
                        name="name" 
                        placeholder="e.g., n8n, Mobile App" 
                        required 
                        class="flex-1 px-3 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors whitespace-nowrap"
                    >
                        Generate Token
                    </button>
                </form>

                @error('name')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <form method="dialog" class="modal-backdrop">
            <button onclick="closeApiTokenModal()">close</button>
        </form>
    </dialog>

    <link href="https://cdn.jsdelivr.net/npm/@n8n/chat/dist/style.css" rel="stylesheet" />

    <style>
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: none;
            place-items: center;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        
        .modal:modal {
            display: grid;
        }
        
        .modal-box {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .dark .modal-box {
            background: #1f2937;
            color: white;
        }
    </style>

    <script type="module">
        import { createChat } from 'https://cdn.jsdelivr.net/npm/@n8n/chat/dist/chat.bundle.es.js';

        const metadata = {
            @if($wg)
            wg_id: '{{ $wg->wg_id }}',
            @endif
        };

        // Only initialize chat when we have a WG to attach
        @if($wg && $chatWebhookUrl)
        createChat({
            webhookUrl: '{{ $chatWebhookUrl }}',
            target: '#n8n-chat',
            mode: 'window',
            metadata,
            loadPreviousSession: true,
            initialMessages: [
                'Hi! Beschreibe kurz das Problem.'
            ],
        });
        @endif
    </script>

    <script>
        function openApiTokenModal() {
            const modal = document.getElementById('apiTokenModal');
            if (modal) {
                modal.showModal();
                // Auto-select token text if it exists
                const tokenDiv = modal.querySelector('[onclick="this.select()"]');
                if (tokenDiv) {
                    tokenDiv.select();
                }
            }
        }

        function closeApiTokenModal() {
            const modal = document.getElementById('apiTokenModal');
            if (modal) {
                modal.close();
            }
        }

        // Auto-open modal if new token was created
        @if (session('new_token'))
            document.addEventListener('DOMContentLoaded', function() {
                openApiTokenModal();
            });
        @endif
    </script>
</x-layouts::app>
