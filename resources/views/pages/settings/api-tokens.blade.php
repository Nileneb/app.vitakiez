<x-layouts::app :title="__('API Tokens Settings')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <h1 class="text-2xl font-bold mb-2">API Tokens</h1>
            <p class="text-neutral-600 dark:text-neutral-400 mb-4">
                Create and manage API tokens for secure authentication with n8n and other integrations.
                <br />Tokens are personal access tokens based on Laravel Sanctum.
            </p>
        </div>

        @if (session('new_token'))
            <div class="rounded-xl border border-green-200 bg-green-50 p-6 dark:border-green-900 dark:bg-green-900/20">
                <h3 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-2">
                    ✅ Token Created Successfully
                </h3>
                <p class="text-sm text-green-800 dark:text-green-200 mb-4">
                    Copy this token now - you won't be able to see it again!
                </p>
                <div class="bg-white dark:bg-neutral-800 p-4 rounded border border-green-300 dark:border-green-700 font-mono text-sm break-all">
                    {{ session('new_token') }}
                </div>
                <p class="text-xs text-green-700 dark:text-green-300 mt-3">
                    💡 Use this token in n8n as: <code class="bg-green-100 dark:bg-green-900 px-2 py-1 rounded">Authorization: Bearer {{ session('new_token') }}</code>
                </p>
            </div>
        @endif

        <!-- Create Token Form -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <h2 class="text-lg font-semibold mb-4">Create New Token</h2>
            
            <form method="POST" action="{{ route('settings.api-tokens.create') }}" class="flex gap-3 flex-col sm:flex-row">
                @csrf
                
                <input 
                    type="text" 
                    name="name" 
                    placeholder="e.g., n8n, Mobile App, etc." 
                    required 
                    class="flex-1 px-3 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors"
                >
                    Generate Token
                </button>
            </form>

            @error('name')
                <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Active Tokens -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <h2 class="text-lg font-semibold mb-4">Active Tokens</h2>
            
            @forelse (auth()->user()->tokens()->latest()->get() as $token)
                <div class="flex items-center justify-between p-4 border border-neutral-200 dark:border-neutral-700 rounded-lg mb-3">
                    <div>
                        <p class="font-semibold">{{ $token->name }}</p>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">
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
                        onsubmit="return confirm('Are you sure you want to revoke this token?')"
                    >
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit" 
                            class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors"
                        >
                            Revoke
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-neutral-600 dark:text-neutral-400 text-center py-8">
                    No tokens created yet. Create one to get started.
                </p>
            @endforelse
        </div>

        <!-- Usage Instructions -->
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-6 dark:border-blue-900 dark:bg-blue-900/20">
            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">
                📋 How to Use in n8n
            </h3>
            <ol class="list-decimal list-inside space-y-2 text-sm text-blue-800 dark:text-blue-200">
                <li>Create a token above and copy it</li>
                <li>In n8n, go to <strong>Credentials → Add new → HTTP</strong></li>
                <li>Set authentication type to <strong>Header</strong></li>
                <li>Add header: <code class="bg-blue-100 dark:bg-blue-900 px-2 py-1 rounded">Authorization: Bearer YOUR_TOKEN</code></li>
                <li>Use this credential in your HTTP requests to this application</li>
            </ol>
        </div>
    </div>
</x-layouts::app>
