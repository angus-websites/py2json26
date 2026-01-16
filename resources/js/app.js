import './bootstrap';

// Alpine Magic Clipboard
document.addEventListener('alpine:init', () => {
    Alpine.magic('clipboard', () => {
        return async (subject) => {

            // Clipboard API availability check
            if (!navigator.clipboard || !window.isSecureContext) {
                Flux.toast('Clipboard is not available in this environment.', {
                    variant: 'danger',
                    duration: 2000
                })
                return false
            }

            try {
                const text = typeof subject?.trim === "function" ? subject.trim() : subject;
                await navigator.clipboard.writeText(text);
            } catch (error) {
                console.error('Clipboard error:', error)
                Flux.toast('Failed to copy to clipboard.', {
                    variant: 'danger',
                    duration: 2000
                })
                return false
            }

            Flux.toast({
                text: 'Copied to clipboard!',
                duration: 2000
            })
            return true
        }
    })
})
