import { reactive, ref } from "vue";

export default function useService({ reload = false } = {}) {
    const loading = ref(false);
    const messages = reactive({
        success: "",
        error: "",
    });

    async function fetch<T>(...services: Promise<any>[]): Promise<T[]> {
        if (services.length === 0) {
            return Promise.resolve([]);
        }

        loading.value = true;

        try {
            const responses = await Promise.all(services);
            loading.value = false;
            messages.success = responses.map((response) => response.message).join(", ");
            messages.error = "";
            setTimeout(() => {
                messages.success = "";
                if (reload) {
                    location.reload();
                }
            }, 4000);

            return responses;
        } catch (error: any) {
            loading.value = false;
            messages.success = "";
            if (error.response) {
                messages.error = error.response.data.message;
            } else {
                messages.error = error.message;
            }
            throw error.response;
        }
    }

    return {
        loading,
        messages,
        fetch,
    };
}

