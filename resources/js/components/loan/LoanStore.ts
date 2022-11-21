import { Equipment, LoanForm, LoanItem } from "./../../types.d";
import { addDays, format } from 'date-fns'
import LoanService from './../../services/LoanService';
import { defineStore } from "pinia";
import { laravelErrorToZodError } from './../../utils/laravelUtils';

export const useLoanStore = defineStore('loan', {
    state: () => ({
        loan: {
            loaner:'',
            items: [] as LoanItem[],
            description: '',
            reason: "Partiotapahtumaan",
        } as LoanForm,
        equipment: null as null | Equipment[],
        errors: undefined as any | undefined,
        isLoading: false,
        messages: [] as any[]
    }),
    actions: {
        addItemToLoan(equipmentId: number) {
            if(this.equipment && this.loan.items) {
    
                const loanEquipment = this.equipment.find(item => item.id === equipmentId)
        
                if (loanEquipment && loanEquipment.quantity > 0) {
                    const loanDays = loanEquipment.loan_time === 0 ? 7 : loanEquipment.loan_time
                    this.loan.items.push({
                        id:loanEquipment.id,
                        name: loanEquipment.name ,
                        quantity: loanEquipment.quantity,
                        loanDate: format(new Date(),'yyyy-MM-dd'),
                        returnDate:format(addDays(new Date(), loanDays),'yyyy-MM-dd')
                    } as LoanItem)
                
                    loanEquipment.loaned = true;
                }
        
            }
    
        },
        removeItemFromLoan(itemId: number){
            if(this.equipment && this.loan.items) {
                this.loan.items = this.loan.items.filter(item => item.id !== itemId)
                const removedItem = this.equipment.find(e => e.id === itemId);
                if(removedItem) removedItem.loaned = false
            }
        },
        submitLoan(){
            this.isLoading = true
            LoanService.storeLoan(this.loan)
            .then(result => {
                this.messages.push(result.message)
                this.isLoading = false
                setTimeout(() => {
                    location.reload();
                }, 3000);
            })
            .catch(result => {
                this.isLoading = false
                this.errors = laravelErrorToZodError(result.response.data.errors)
            })
        }
    },
  })
