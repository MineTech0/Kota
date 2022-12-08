export interface LoanForm {
    loaner: string;
    items: LoanItem[]
    description: string;
    reason: string;
}

interface LoanItem {
    id: number;
    name: string;
    quantity: number;
    loanDate: string;
    returnDate: string;
}

export interface Equipment {
    id: number;
    name: string;
    weight: number;
    form: string | null;
    location: string;
    quantity: number;
    loan_time: number;
    info: string | null;
    serial: string | null;
    picture: string | null;
    loaned?: boolean;
}

export interface Loan {
    id: number;
    loan_date: string;
    return_date: string;
    quantity: number;
    desc: string;
    reason: string;
    state: number;
    equipment: Equipment
}

export interface FileI {
    id: number;
    name: string;
    category: string;
    path: string;
    permission: string | null;
    extension: string | null;
    isUrl: boolean;
}