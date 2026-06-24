import type { Auth } from '@/types/auth';

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            name: string;
            auth: Auth;
            can: Can;
            sidebarOpen: boolean;
            [key: string]: unknown;
        };
    }
}
