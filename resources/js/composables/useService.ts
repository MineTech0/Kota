import { AxiosError } from "axios";
import { reactive, ref } from "vue";

export default function useService() {
    const loading = ref(false);
    const messages = reactive({
        success: "",
        error: "",
    });

    function fetch<T>(service: Promise<any>): Promise<T> {
        return new Promise((resolve, reject) => {
            loading.value = true;

            service
                .then((response) => {
                    loading.value = false;
                    messages.success = response.message;
                    messages.error = "";
                    setTimeout(() => {
                        messages.success = "";
                    }, 4000);
                    resolve(response);
                })
                .catch((err: AxiosError<{ message: string }>) => {
                    loading.value = false;
                    messages.success = "";
                    if (err.response) {
                        messages.error = err.response.data.message;
                    } else {
                        messages.error = err.message;
                    }
                    reject(err.response);
                });
        });
    };

    return {
        loading,
        messages,
        fetch,
    };
}
