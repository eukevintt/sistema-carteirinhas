import axios from 'axios';
window.axios = axios;

import select2 from 'select2';
select2();

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
