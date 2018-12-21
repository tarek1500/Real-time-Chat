export const domainUrl = 'http://localhost/chat/public/'

// Add Client ID & Secret
export const clientId = 0, clientSecret = ''

var accessToken = null, refreshToken = null

export const setTokens = function (_accessToken, _refreshToken) {
	accessToken = _accessToken
	refreshToken = _refreshToken
}

export const getHeader = function () {
	return {
		'Accept': 'application/json',
		'Authorization': 'Bearer ' + accessToken
	}
}