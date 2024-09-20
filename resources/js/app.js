import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import UIkit from "franken-ui/js/core.iife";
window.UIkit = UIkit;

import 'franken-ui/js/icon.iife';
