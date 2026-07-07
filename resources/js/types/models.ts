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
    | 'failed'
    | 'available';

export const TERM_PAPER_STATUS_LABELS: Record<TermPaperStatus, string> = {
    pending: 'В изчакване',
    accepted: 'Приет',
    rejected: 'Отхвърлен',
    revision_required: 'Нужда от ревизия',
    in_review: 'Провежда се разглеждане',
    defended: 'Защитена',
    failed: 'Неуспешно положена дипломна работа',
    available: 'Налична',
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
    claimed_at: string | null;
    file_path: string | null;
    teacher?: UserOption;
    student?: UserOption;
    remark?: Remark | null;
    status_histories?: TermPaperStatusHistory[];
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
    pending: 'В изчакване',
    currently_reviewed: 'Сега се разглежда',
    passed_recension: 'Минала рецензия',
    failed_recension: 'Рецензия неуспешно премината',
    revision_required: 'Нужда от ревизия',
    resubmitted: 'Изпратена наново',
    assigned: 'Зададена',
    expired: 'Изтекла',
};

export type ConsultationType = 'online' | 'in_person';

export const CONSULTATION_TYPE_LABELS: Record<ConsultationType, string> = {
    online: 'Онлайн',
    in_person: 'На живо',
};

export type ConsultationStatus = 'pending' | 'accepted' | 'rejected';

export const CONSULTATION_STATUS_LABELS: Record<ConsultationStatus, string> = {
    pending: 'В изчакване',
    accepted: 'Приета',
    rejected: 'Отхвърлена',
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
    university: 'Университет',
    specialized_higher_school: 'Специализирано висше училище',
    independent_college: 'Независим колеж',
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
export interface TermPaperStatusHistory {
    id: number;
    term_paper_id: number;
    label: string;
    status: TermPaperStatus | null;
    happened_at: string;
}
export type GenAiCheckStatus =
    | 'not_checked'
    | 'low_risk'
    | 'medium_risk'
    | 'high_risk';

export const GENAI_CHECK_STATUS_LABELS: Record<GenAiCheckStatus, string> = {
    not_checked: 'Непроверено',
    low_risk: 'Нисък риск',
    medium_risk: 'Среден риск',
    high_risk: 'Висок риск',
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
    plagiarism_percentage: number | null;
    genai_status: GenAiCheckStatus;
    term_paper?: UserOption;
    remark?: Remark | null;
    reviewer?: UserOption;
    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}
