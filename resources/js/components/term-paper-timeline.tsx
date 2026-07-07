import { TERM_PAPER_STATUS_LABELS } from '@/types/models';
import type { TermPaperStatusHistory } from '@/types/models';

interface Props {
    histories: TermPaperStatusHistory[];
}

export default function TermPaperTimeline({ histories }: Props) {
    if (histories.length === 0) {
        return (
            <p className="text-sm text-muted-foreground">
                Няма записана история.
            </p>
        );
    }

    return (
        <div className="flex gap-6 overflow-x-auto pt-2 pb-4">
            {histories.map((item, i) => {
                const isAbove = i % 2 === 0;
                const date = new Date(item.happened_at).toLocaleDateString(
                    'bg-BG',
                );

                return (
                    <div
                        key={item.id}
                        className="flex w-44 shrink-0 flex-col items-center"
                    >
                        {isAbove && (
                            <div className="mb-2 text-center">
                                <p className="text-sm font-medium">
                                    {item.label}
                                </p>
                                <p className="text-xs text-muted-foreground">
                                    {date}
                                </p>
                            </div>
                        )}

                        <div className="flex w-full items-center">
                            <div className="h-px flex-1 bg-border" />
                            <div className="h-3 w-3 rounded-full border-2 border-primary bg-background" />
                            <div className="h-px flex-1 bg-border" />
                        </div>

                        {!isAbove && (
                            <div className="mt-2 text-center">
                                <p className="text-sm font-medium">
                                    {item.label}
                                </p>
                                <p className="text-xs text-muted-foreground">
                                    {date}
                                </p>
                            </div>
                        )}
                    </div>
                );
            })}
        </div>
    );
}
