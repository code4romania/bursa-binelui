import { createI18n } from 'vue-i18n';
import en from '../locales/en.js';
import ro from '../locales/ro.js';

export default createI18n({
    legacy: false,
    locale: 'ro',
    fallbackLocale: 'ro',
    messages: { ro, en }
});
