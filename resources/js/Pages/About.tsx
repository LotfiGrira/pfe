import GuestLayout from '@/Layouts/GuestLayout';
import { PageProps } from '@/types';

type Props = {
    text: string
};

export default function About({
    text
}: PageProps<Props>) {
    return <GuestLayout>
        <div>{text}</div>
    </GuestLayout>;
}