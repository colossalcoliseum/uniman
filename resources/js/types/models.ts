export interface UserOption{
    id: number;
    name: string;
}
export interface Remark{
    id: number;
    name: string;
}
export type TermPaperStatus =
    | 'pending'
    | 'accepted'
    | 'rejected'
    | 'revision_required'
    | 'in_review'
    | 'defended'
    | 'failed';
export const TERM_PAPER_STATUS_LABELS: Record<TermPaperStatus, string> = {
    pending:'Pending',
    accepted:'Accepted',
    rejected:'Rejected',
    revision_required:'Revision Required',
    in_review:'In review',
    defended:'Defended',
    failed:'Failed',
}
export interface TermPaper{
    id: number;
    name: string;
    slug: string;
    teacher_id: number;
    student_id: number;
    start_date: string;
    end_date: string;
    status: TermPaperStatus;
    teacher?: UserOption;
    student?: UserOption;
    remark?: Remark|null;
    created_at: string;
    updated_at: string;
    deleted_at: string;
}
export interface Paginated<T>{
    data:T[];
    current_page:number;
    last_page:number;
    per_page:number;
    total:number;
    from:number|null;
    to:number|null;
}
