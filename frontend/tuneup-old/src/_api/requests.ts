import { useGlobalStore } from "../_store/globalStore"
import { useMessageStore } from "../_store/messageStore"

const url = "http://localhost:8080"

function handleError(response: Response, json: any) {
    const store = useMessageStore()

    store.setError(`${response.status}`, json.message)
    return true
}

async function handleResponse(response:Response, route:String, handleErrorMessage:Boolean) {
    console.log(response, "before requests")
    const store = useGlobalStore()
    const json = await response.json()
    if (route == '/auth/login') {
        if(handleErrorMessage && response.status != 200) {
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
    
    
    console.log(response, "in requests")
    //console.log(json)
    return {response: response, body: json}

}

export async function postFetch(route:String, body:Object, handleError:boolean = true) {
    
    const response = await fetch(`${url}${route}`, {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    return await handleResponse(response, route, handleError)
}

export async function getFetch(route:String, handleError:boolean = true) {
    return await handleResponse(await fetch(`${url}${route}`, {
        method: 'GET'
    }), route, handleError)
}