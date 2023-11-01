import axios from "axios";
import { useGlobalStore } from "../_store/globalStore";

let retry = false
const axiosWrapper = axios.create({
    baseURL: "http://localhost:8080/",
    withCredentials: true,
    // signal: AbortSignal.timeout(3000)
})
axiosWrapper.defaults.headers.common['Content-Type'] = 'application/json';
axiosWrapper.interceptors.request.use((config) => {
    const { userInfo } = useGlobalStore()
    if (userInfo.token) {
        config.headers.Authorization = `Bearer ${userInfo.token}`
    }
    return config
}, (error) => {
    return Promise.reject(error)
})
axiosWrapper.interceptors.response.use(
    (response) => {
        return response.data
    },
    async (error) => {
        const { userInfo, logout } = useGlobalStore()
        const originalRequest = error.config
        const errMessage = error.response.data.message as string
        if ([401, 403].includes(error.response.status) && !retry) {
            userInfo.token = null
            retry = true
            const refreshResponse = await refreshToken()
            userInfo.token = refreshResponse.token
            return await axiosWrapper(originalRequest)
        } else if([401, 403].includes(error.response.status) && retry) {
            retry = false
            logout()
        }
        return Promise.reject(error)
    }
)

async function refreshToken() {
    const response = await axiosWrapper.get('/auth/refresh')
    return response
}

export default axiosWrapper