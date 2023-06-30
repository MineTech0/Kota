import { ref } from 'vue';

export default function useRedirect() {
  const redirecting = ref(false);

  function redirect(url) {
    redirecting.value = true;
    setTimeout(() => {
      window.location.href = url;
    }, 3000);
  }

  return { redirecting, redirect };
}