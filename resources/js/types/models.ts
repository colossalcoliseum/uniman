// Минимален "избор" от User, какъвто връща контролерът чрез ->with('teacher:id,name')
export interface UserOption {
    id: number;
    name: string;
}

export interface Remark {
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
    pending: 'Pending',
    accepted: 'Accepted',
    rejected: 'Rejected',
    revision_required: 'Revision Required',
    in_review: 'In Review',
    defended: 'Defended',
    failed: 'Failed',
};

export interface TermPaper {
    id: number;
    name: string;
    slug: string;
    teacher_id: number;
    student_id: number;
    remark_id: number | null;
    start_date: string;
    end_date: string;
    status: TermPaperStatus;
    teacher?: UserOption;
    student?: UserOption;
    remark?: Remark | null;
    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}

// Laravel LengthAwarePaginator shape, какъвто Inertia сериализира
export interface Paginated<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
}

export type RecensionStatus =
    | 'pending'
    | 'currently_reviewed'
    | 'passed_recension'
    | 'failed_recension'
    | 'revision_required'
    | 'resubmitted'
    | 'assigned'
    | 'expired';

export const RECENSION_STATUS_LABELS: Record<RecensionStatus, string> = {
    pending: 'Pending',
    currently_reviewed: 'Currently Reviewed',
    passed_recension: 'Passed Recension',
    failed_recension: 'Failed Recension',
    revision_required: 'Revision Required',
    resubmitted: 'Resubmitted',
    assigned: 'Assigned',
    expired: 'Expired',
};

export interface Recension {
    id: number;
    title: string;
    term_paper_id: number;
    remark_id: number | null;
    reviewer_id: number;
    status: RecensionStatus;
    final_verdict: string;
    passed: boolean;
    term_paper?: UserOption; // {id, name} от eager-loaded termPaper relation
    remark?: Remark | null;
    reviewer?: UserOption;
    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}

export type ConsultationType = 'online' | 'in_person';

export const CONSULTATION_TYPE_LABELS: Record<ConsultationType, string> = {
    online: 'Online',
    in_person: 'In Person',
};

export type ConsultationStatus = 'pending' | 'accepted' | 'rejected';

export const CONSULTATION_STATUS_LABELS: Record<ConsultationStatus, string> = {
    pending: 'Pending',
    accepted: 'Accepted',
    rejected: 'Rejected',
};

export interface Consultation {
    id: number;
    term_paper_id: number;
    teacher_id: number;
    student_id: number;
    starts_at: string | null;
    ends_at: string | null;
    type: ConsultationType;
    status: ConsultationStatus;
    location: string | null;
    notes: string | null;
    attended: boolean | null;
    teacher?: UserOption;
    student?: UserOption;
    term_paper?: UserOption;
    created_at: string;
    updated_at: string;
}

export interface Country {
    id: number;
    name: string;
}

export type InstitutionType =
    | 'university'
    | 'specialized_higher_school'
    | 'independent_college';

export const INSTITUTION_TYPE_LABELS: Record<InstitutionType, string> = {
    university: 'University',
    specialized_higher_school: 'Specialized Higher School',
    independent_college: 'Independent College',
};

export interface Institution {
    id: number;
    name: string;
    slug: string;
    type: InstitutionType;
    country_id: number;
    description: string | null;
    manager_id: number;
    logo: string | null;
    country?: Country;
    manager?: UserOption;
    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}
export interface Faculty {
    id: number;
    name: string;
    slug: string;
    institution_id: number;
    country_id: number;
    dean_id: number;
    institution?: UserOption;
    dean?: UserOption;
    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}
export interface Specialty {
    id: number;
    name: string;
    slug: string;
    institution_id: number;
    institution?: UserOption;
    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}
