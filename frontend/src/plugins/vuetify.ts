import { createVuetify } from 'vuetify'
import 'vuetify/styles'

const savedTheme = typeof window !== 'undefined'
  ? (localStorage.getItem('theme') || 'dark')
  : 'dark'

export default createVuetify({
  theme: {
    defaultTheme: savedTheme,
    themes: {
      dark: {
        dark: true,
        colors: {
          background: '#0f172a',
          surface:    '#1e293b',
          primary:    '#eab308',
          secondary:  '#64748b',
          error:      '#ef4444',
          info:       '#3b82f6',
          success:    '#22c55e',
          warning:    '#f97316',
        },
      },
      light: {
        dark: false,
        colors: {
          background: '#f1f5f9',
          surface:    '#ffffff',
          primary:    '#eab308',
          secondary:  '#475569',
          error:      '#dc2626',
          info:       '#2563eb',
          success:    '#16a34a',
          warning:    '#ea580c',
        },
      },
    },
  },
  defaults: {
    VCard:      { rounded: 'lg' },
    VBtn:       { rounded: 'lg' },
    VTextField: { variant: 'outlined', density: 'comfortable' },
    VSelect:    { variant: 'outlined', density: 'comfortable' },
  },
})
