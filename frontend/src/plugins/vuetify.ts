import { createVuetify } from 'vuetify'
import 'vuetify/styles'

export default createVuetify({
  theme: {
    defaultTheme: 'dark',
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
    },
  },
  defaults: {
    VCard:      { rounded: 'lg' },
    VBtn:       { rounded: 'lg' },
    VTextField: { variant: 'outlined', density: 'comfortable' },
    VSelect:    { variant: 'outlined', density: 'comfortable' },
  },
})
