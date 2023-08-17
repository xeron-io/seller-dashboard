"use strict";

const store_name = document.querySelector("#store_name");
const store_description = document.querySelector("#store_description");
const store_domain = document.querySelector("#store_domain");
const youtube = document.querySelector("#youtube");
const instagram = document.querySelector("#instagram");
const tiktok = document.querySelector("#tiktok");
const discord = document.querySelector("#discord");
const phone = document.querySelector("#phone");

const getData = async () => {
	const response = await fetch("/dashboard/store/1");
	const data = await response.json();
	return data;
};

const setData = async () => {
	const data = await getData();

	data.forEach((store, index) => {
		const bntEdit = document.querySelector(`#btnEdit-4d4f0d2c-976e-49f4-8180-5fa7cd459b1b`);

		console.log(bntEdit);
	});
};

setData();