const config = {
  firebase: {
    databaseURL: import.meta.env.VITE_FIREBASE_DATABASE_URL || ''
  }
}

// validate required configs
if (!config.firebase.databaseURL) {
  throw new Error('Missing required environment variable: VITE_FIREBASE_DATABASE_URL')
}

export default config
