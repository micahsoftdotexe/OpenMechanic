import { useGlobalStore } from "../_store/globalStore";

const hostUrl = "http://localhost:8080"
// const globalStore = useGlobalStore()
export const fetchWrapper = {
    get: request('GET'),
    post:  request('POST'),
    put:  request('PUT'),
    delete: request('DELETE')
};

function request(method) {
    return async (url, body = null) => {
        
        //return fetch(url, requestOptions).then(handleResponse);
        const requestInfo = getRequestInfo(url, body, method)
        console.log(requestInfo)
        const fetchResponse = await fetch(requestInfo.url, requestInfo.requestOptions)
        return await handleResponse(fetchResponse, {url, body, method})
    }
}

function getRequestInfo(url, body, method) {
    url = `${hostUrl}${url}`
    const requestOptions = {
        method,
        headers: authHeader(url)
    };
    if (body) {
        requestOptions.headers['Content-Type'] = 'application/json';
        requestOptions.body = JSON.stringify(body);
    }
    return {url, requestOptions}
}

// helper functions

function authHeader(url) {
    // console.log("authHeader")
    // return auth header with jwt if user is logged in and request is to the api url
    const { userInfo } = useGlobalStore();
    const isLoggedIn = !!userInfo?.token;
    // console.log("token", userInfo.token)
    const isApiUrl = url.startsWith(import.meta.env.VITE_API_URL);
    if (isLoggedIn) {
        return { Authorization: `Bearer ${userInfo.token}` };
    } else {
        return {};
    }
}

async function handleResponse(response, initialRequest) {
    console.log(response)
    const text = await response.text()
    const data = JSON.parse(text);
    
    if (!response.ok) {
        const { userInfo, logout } = useGlobalStore();
        if ([401, 403].includes(response.status) && userInfo) {
            const refreshResponse = await checkRefreshToken() 
            if (refreshResponse == true) {
                //retry
                console.log("true")
                const newRequestInfo = getRequestInfo(initialRequest.url,initialRequest.body, initialRequest.method)
                const fetchResponse = await fetch(newRequestInfo.url, newRequestInfo.requestOptions)
                const newText = await fetchResponse.text()
                const newData = newText && JSON.parse(text);
                if (!fetchResponse.ok) {
                    const error = (data && newData) || fetchResponse.statusText;
                    return Promise.reject(error);
                }
                return data
            }
            // auto logout if 401 Unauthorized or 403 Forbidden response returned from api
            logout();
        }

        const error = (data && data.message) || response.statusText;
        return Promise.reject(error);
    }

    return data;
}

async function checkRefreshToken() : Promise<Boolean>{
    const globalStore = useGlobalStore()
    const refreshResponse = await fetch(`${hostUrl}/auth/refresh`)
    const text = await refreshResponse.text()
    const data = text && JSON.parse(text)

    if(refreshResponse.status == 200) {
        globalStore.userInfo.token = data.token
        return true
    }
    return false
}
