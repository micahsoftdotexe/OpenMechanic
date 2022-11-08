import { useGlobalStore } from "../_store/globalStore"

const url = "http://localhost:8080"

function handleError(response: Response, json: any) {
    const store = useGlobalStore()

    store.setError(`${response.status}`, json.message)
    return true
}

async function handleResponse(response:Response, route:String, handleErrorMessage:Boolean) {
    const store = useGlobalStore()
    const json = await response.json()
    if (route == '/auth/login') {
        if (response.status == 200) {
            store.login(json.user)
        } else if(handleErrorMessage) {
            handleError(response, json)
        }
    } else {
        if (response.status != 200) {
            if (response.status == 401) {
                store.logout()
                if (handleErrorMessage) {
                    handleError(response, {message: 'User timeout'})
                }
            }
            if (handleErrorMessage) {
                handleError(response, json)

            }
        }
    }
    
    
    //console.log(response)
    //console.log(json)
    return response

}

export async function postFetch(route:String, body:Object, handleError:boolean = true) {
    
    return await handleResponse(await fetch(`${url}${route}`, {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
            'Content-Type': 'application/json'
        }
    }), route, handleError)
}

export async function geFetch(route:String, handleError:boolean = true) {
    return await handleResponse(await fetch(`${url}${route}`, {
        method: 'GET'
    }), route, handleError)
}