import { initializeApp } from 'firebase/app'
import { getDatabase } from 'firebase/database'
import config from './config'

const firebaseConfig = {
  databaseURL: config.firebase.databaseURL
}

const app = initializeApp(firebaseConfig)
export const db = getDatabase(app)
