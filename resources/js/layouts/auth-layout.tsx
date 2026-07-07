import AuthLayoutTemplate from '@/layouts/auth/auth-simple-layout';
import { useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import flasher from '@flasher/flasher';
export default function AuthLayout({
    children,
    title,
    description,
    ...props
}: {
    children: React.ReactNode;
    title: string;
    description: string;
}) {
    const { messages } = usePage().props;

    useEffect(() => {
        if (messages) {
            flasher.render(messages);
        }
    }, [messages]);
    return (
        <AuthLayoutTemplate title={title} description={description} {...props}>
            {children}
        </AuthLayoutTemplate>
    );
}
