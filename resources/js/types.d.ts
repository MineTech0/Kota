export interface User {
    id: number;
    name: string;
    email: string;
}

export interface Role {
    id: number;
    name: string;
}
export interface UserWithRoles extends User {
    roles: Role[]
}
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
    form: string;
    location: string;
    quantity: number;
    loan_time: number;
    info: string;
    serial: string
    picture: string;
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

export interface Group {
    id: number;
    name: string;
    meeting_day: string;
    meeting_start: string;
    meeting_end: string;
    repeat: string;
    age: string;
    leaders: User[]
}

export interface GroupForm {
    name: string;
    meeting_day: string;
    meeting_start: string;
    meeting_end: string;
    repeat: string;
    age: string;
    leaders: User[]
}

export interface ExpenseInfos {
    group: string[]
    budget: string[]
}

interface NewGroupExpense {
    groupId: number | null;
    amount: number;
    expense_date: number;
    description: string;
}

interface GroupExpense {
    id: number;
    groupId: number | null;
    amount: number;
    expense_date: string;
    description: string;
    acceptor_id: number | null;
}

export interface GroupWithExpenses  extends Group {
    expenses: GroupExpense[]
}
export interface AgeGroupExpenses {
    age: string;
    expenses: GroupWithExpenses[]
}