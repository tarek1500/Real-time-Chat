export default {
	methods: {
		generateFlashString (heading, errors = null) {
			let message = '<h5>' + heading + '</h5>'

			if (errors && Object.keys(errors).length > 0) {
				message += '<hr><ul>'

				for (const key in errors)
					if (errors.hasOwnProperty(key)) {
						const error = errors[key];

						if (error) {
							message += '<li><span>' + key + ':</span>'

							if (error.length == 1)
								message += ' ' + error[0] + ' </li>'
							else {
								message += '<ol>'
								error.forEach(element => {
									message += '<li>' + element + '</li>'
								});
								message += '</ol></li>'
							}
						}
					}
				message += '</ul>'
			}

			return message
		}
	}
}