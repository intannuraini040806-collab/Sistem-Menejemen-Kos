<?php

namespace App\Http\Requests\Pembayaran;

use Illuminate\Foundation\Http\FormRequest;

class StorePembayaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isPenghuni();
    }

    public function rules(): array
    {
        return [
            'metode_pembayaran' => ['required', 'in:transfer,tunai'],
            'jumlah_bayar' => ['required', 'integer', 'min:1'],
            'tanggal_pembayaran' => ['required', 'date', 'before_or_equal:today'],
            'bukti_pembayaran' => [
                'nullable',
                'required_if:metode_pembayaran,transfer',
                'file',
                'mimes:jpg,jpeg,png,webp,pdf',
                'max:2048',
            ],
            'catatan' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
            'metode_pembayaran.in' => 'Metode pembayaran harus Transfer Bank atau Tunai.',
            'jumlah_bayar.required' => 'Nominal pembayaran wajib diisi.',
            'jumlah_bayar.integer' => 'Nominal pembayaran harus berupa angka bulat.',
            'jumlah_bayar.min' => 'Nominal pembayaran minimal Rp 1.',
            'tanggal_pembayaran.required' => 'Tanggal pembayaran wajib diisi.',
            'tanggal_pembayaran.date' => 'Format tanggal pembayaran tidak valid.',
            'tanggal_pembayaran.before_or_equal' => 'Tanggal pembayaran tidak boleh melebihi hari ini.',
            'bukti_pembayaran.required_if' => 'Bukti transfer wajib diunggah untuk metode Transfer Bank.',
            'bukti_pembayaran.file' => 'Bukti pembayaran harus berupa file yang valid.',
            'bukti_pembayaran.mimes' => 'Format bukti pembayaran harus JPG, PNG, WEBP, atau PDF.',
            'bukti_pembayaran.max' => 'Ukuran file bukti pembayaran maksimal 2 MB.',
            'catatan.max' => 'Catatan maksimal 500 karakter.',
        ];
    }
}

