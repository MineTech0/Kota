import { defineStore } from "pinia";
import { NewGroupExpense } from "../../types";
import ExpenseService from './../../services/ExpenseService';

interface State {
    groupExpenses: NewGroupExpense[]
}

const today = new Date().getTime();

const defaultState = {
    groupExpenses: [
        {
            groupId: null,
            amount: 0,
            expense_date: today,
            description: "",
        },
    ]
}

export const useCreateExpensesStore = defineStore('expense', {
    state: (): State => ({...defaultState}),
    actions: {
        /**
         * Adds new empty groupExpense
         */
        addGroupExpense(){
            this.groupExpenses.push({
                groupId: null,
                amount: 0,
                expense_date: today,
                description: "",
            });
        },
        /**
         * Deletes group expense from store
         * @param index number
         */
        removeGroupExpense(index){
            this.groupExpenses.splice(index, 1);
        },

        /**
         * Resets groupExpenses
         */
        resetGroupExpenses(){
            this.groupExpenses = []
            this.addGroupExpense()
        },

        /**
         * Save group expenses to service
         */
        storeGroupExpenses(){
           return ExpenseService.storeGroupExpenses(this.groupExpenses)
        }
    },
  })