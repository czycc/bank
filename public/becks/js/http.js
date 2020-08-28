
const baseUrl = "https://gd.shanghaichujie.com/api/v1"
const request = (api, params = {}, method = 'get') => {

	// 加入Token
	headers = {
		// token: tokenInfo ? `${tokenInfo.token_type} ${tokenInfo.access_token}` : ''
	}

	return new Promise((resolve, reject) => {
		axios({
				method: method,
				url: api,
				baseURL: baseUrl,
				headers: headers,
				params: params
			})
			.then((response) => {
				resolve(response.data)
			}).catch((error) => {
				reject(error.response.data)
			})
	})
}