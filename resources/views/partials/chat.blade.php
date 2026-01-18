<!-- n8n Chat - CDN Embed -->
<link href="https://cdn.jsdelivr.net/npm/@n8n/chat/dist/style.css" rel="stylesheet" />
<div id="n8n-chat"></div>
<script type="module">
    import { createChat } from 'https://cdn.jsdelivr.net/npm/@n8n/chat/dist/chat.bundle.es.js';

    // Initialize chat with webhook URL from controller
    createChat({
        webhookUrl: '{{ $chatWebhookUrl ?? config('services.n8n.chat_url') }}',
        target: '#n8n-chat',
        mode: 'window',
        loadPreviousSession: true,
        showWelcomeScreen: false,
        defaultLanguage: 'de',
        initialMessages: [
            'Hallo! 👋',
            'Wie kann ich dir heute helfen?'
        ],
        i18n: {
            de: {
                title: 'Hallo! 👋',
                footer: 'Du suchst Probleme? Lass uns gemeinsam suchen!',
                getStarted: 'Neue Unterhaltung',
                inputPlaceholder: 'Schreibe deine Frage…',
            }
        },
        enableStreaming: true,
        metadata: {
            'X-WG-ID': '{{ $wg?->wg_id ?? auth()->user()?->active_wg_id ?? '' }}'
        }
    });

    // DEBUG: Log metadata in browser console
    console.log('[n8n Chat] Metadata being sent:', {
        'X-WG-ID': '{{ $wg?->wg_id ?? auth()->user()?->active_wg_id ?? '' }}',
        'resolved_value': '{{ $wg?->wg_id ?? auth()->user()?->active_wg_id }}',
        'wg_object': {{ $wg ? 'true' : 'false' }},
        'user_active_wg_id': '{{ auth()->user()?->active_wg_id }}'
    });

</script>
