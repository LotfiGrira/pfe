import GuestLayout from '@/Layouts/GuestLayout';
import { PageProps } from '@/types';

type Props = {
    text: string
};

export default function Exercice({
    text
}: PageProps<Props>) {
    return <GuestLayout>
        <div>{text}</div>
    </GuestLayout>;

}