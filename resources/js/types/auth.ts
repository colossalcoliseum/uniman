export type User = {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    two_factor_enabled?: boolean;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
};

export type Auth = {
    user: User;
};

export type TwoFactorSetupData = {
    svg: string;
    url: string;
};

export type TwoFactorSecretKey = {
    secretKey: string;
};

export type Can = {
    termPapers: { viewAny: boolean };
    consultations: { viewAny: boolean };
    recensions: { viewAny: boolean };
    specialties: { viewAny: boolean };
    faculties: { viewAny: boolean };
    institutions: { viewAny: boolean };
    users: {
        viewTeachers: boolean;
        viewStudents: boolean;
        viewIndividualProfiles: boolean;
    };
};
