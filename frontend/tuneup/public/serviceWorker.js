

let jwt = '';
const hostUrl = "http://localhost:8080"

isAuthenticated = async (request) => {
    const apiResponse = await fetch(request)
    let json = apiResponse
    if (json.status == 401 && json.message && json.message == "Your request was made with invalid or expired JSON Web Token.") {
        console.log(json.status)
        const refreshResponse = await (await fetch(`${url}/auth/refresh`)).json()
        if (refreshResponse.code == 200) {
            jwt = refreshResponse.token
            return await (await fetch(request)).json
            
        } else {
            return refreshResponse
        }

        return apiResponse
    }
}

const storeJwt = async (request) => {
    const apiResponse = await fetch(request)
    console.log(apiResponse)
    let json = await apiResponse.json()
    if (json.token) {
        jwt = json.token
        delete json.token
    }
    return new Response(JSON.stringify(json), {
        headers: apiResponse.headers
    })
}

self.addEventListener("fetch", async (event) => {
    const url = new URL(event.request.url)
    //console.log(url)
    if (url.origin == hostUrl) {
        //console.log("Here")
        if (url.pathname === '/auth/login') {
            //console.log(event.request.body)
            const jwtResponse = storeJwt(event.request)
            event.respondWith(jwtResponse)
            return
        }
    } else {
        event.respondWith(fetch(event.request))
    }
    
    // } else {
    //     const newRequest = new Request(event.request, {
    //         headers: {"Authorization": `Bearer ${jwt}`},
    //         mode: "no-cors"
    //     });
    //     event.respondWith(new Response(JSON.stringify(isAuthenticated(newRequest))))
    //     return
    // }
    
    //return fetch(newRequest);
})
//export{}