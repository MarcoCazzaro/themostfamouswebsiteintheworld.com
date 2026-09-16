import './bootstrap';

window.ssnailHardRefreshPage = () => {
    const url = new URL(window.location.href);
    url.searchParams.set('refresh', Date.now().toString());
    window.location.href = url.toString();
};